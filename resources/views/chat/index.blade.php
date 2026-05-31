<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat — SIMP-PRO</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>* { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-100 h-screen flex">
@php use Illuminate\Support\Facades\Storage; @endphp

    {{-- Sidebar daftar user --}}
    <div class="w-72 bg-white border-r border-gray-200 flex flex-col">
        <div class="p-4 border-b border-gray-100">
            <h2 class="font-bold text-gray-800 text-sm">Chat</h2>
            <p class="text-xs text-gray-400">{{ auth()->user()->name }}</p>
        </div>
        <div class="overflow-y-auto flex-1">
            @forelse($users as $user)
            <div onclick="openChat({{ $user->id }}, '{{ $user->name }}', '{{ $user->avatar ? Storage::url($user->avatar) : '' }}')"
                 id="user-item-{{ $user->id }}"
                 class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-50 transition user-item">
                <div class="relative">
                    <img src="{{ $user->avatar ? Storage::url($user->avatar) : '' }}"
                         class="w-9 h-9 rounded-full object-cover flex-shrink-0"
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=3b5bdb&color=fff&size=36'">
                </div>
                <div class="flex-1 overflow-hidden">
                    <p class="text-sm font-medium text-gray-700 truncate">{{ $user->name }}</p>
                    <p class="text-xs text-gray-400 capitalize">{{ $user->role }}</p>
                </div>
                @if(isset($unreadCounts[$user->id]) && $unreadCounts[$user->id] > 0)
                <span class="bg-blue-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center unread-badge-{{ $user->id }}">
                    {{ $unreadCounts[$user->id] }}
                </span>
                @else
                <span class="bg-blue-600 text-white text-xs rounded-full w-5 h-5 items-center justify-center hidden unread-badge-{{ $user->id }}">0</span>
                @endif
            </div>
            @empty
            <p class="text-center text-gray-400 text-sm mt-8">Tidak ada user lain.</p>
            @endforelse
        </div>
        <div class="p-4 border-t border-gray-100">
            <a href="javascript:history.back()" class="text-xs text-blue-600 hover:underline">← Kembali</a>
        </div>
    </div>

    {{-- Area chat --}}
    <div class="flex-1 flex flex-col">

        {{-- Header chat --}}
        <div id="chat-header" class="bg-white border-b border-gray-200 px-6 py-4 hidden">
            <div class="flex items-center gap-3">
                <img id="chat-avatar" src="" class="w-9 h-9 rounded-full object-cover"
                     onerror="this.src='https://ui-avatars.com/api/?name=User&background=3b5bdb&color=fff&size=36'">
                <div>
                    <p id="chat-name" class="font-semibold text-gray-800 text-sm"></p>
                    <p class="text-xs text-green-500">Online</p>
                </div>
            </div>
        </div>

        {{-- Placeholder --}}
        <div id="chat-placeholder" class="flex-1 flex items-center justify-center">
            <div class="text-center">
                <svg class="w-16 h-16 text-gray-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
                <p class="text-gray-400 text-sm">Pilih user untuk mulai chat</p>
            </div>
        </div>

        {{-- Pesan --}}
        <div id="chat-messages" class="flex-1 overflow-y-auto p-6 space-y-3 hidden"></div>

        {{-- Input pesan --}}
        <div id="chat-input" class="bg-white border-t border-gray-200 px-6 py-4 hidden">
            <div class="flex gap-3">
                <input type="text" id="message-input" placeholder="Tulis pesan..."
                       class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                       onkeydown="if(event.key==='Enter') sendMessage()">
                <button onclick="sendMessage()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition">
                    Kirim
                </button>
            </div>
        </div>
    </div>

<script>
    const myId = {{ auth()->id() }};
    const myName = "{{ auth()->user()->name }}";
    let activeUserId = null;
    let pollingInterval = null;

    function openChat(userId, userName, userAvatar) {
        activeUserId = userId;

        // Update header
        document.getElementById('chat-header').classList.remove('hidden');
        document.getElementById('chat-placeholder').classList.add('hidden');
        document.getElementById('chat-messages').classList.remove('hidden');
        document.getElementById('chat-input').classList.remove('hidden');
        document.getElementById('chat-name').textContent = userName;
        document.getElementById('chat-avatar').src = userAvatar ||
            `https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=3b5bdb&color=fff&size=36`;

        // Highlight user aktif
        document.querySelectorAll('.user-item').forEach(el => el.classList.remove('bg-blue-50'));
        document.getElementById(`user-item-${userId}`).classList.add('bg-blue-50');

        // Load pesan
        loadMessages();

        // Polling setiap 2 detik
        if (pollingInterval) clearInterval(pollingInterval);
        pollingInterval = setInterval(loadMessages, 2000);
    }

    function loadMessages() {
        if (!activeUserId) return;
        fetch(`/chat/messages/${activeUserId}`)
            .then(r => r.json())
            .then(messages => {
                const container = document.getElementById('chat-messages');
                const wasAtBottom = container.scrollHeight - container.clientHeight <= container.scrollTop + 10;

                container.innerHTML = messages.map(msg => {
                    const isMine = msg.sender_id === myId;
                    const time = new Date(msg.created_at).toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit'});
                    return `
                        <div class="flex ${isMine ? 'justify-end' : 'justify-start'}">
                            <div class="max-w-xs lg:max-w-md">
                                <div class="${isMine
                                    ? 'bg-blue-600 text-white rounded-2xl rounded-br-sm'
                                    : 'bg-white text-gray-800 rounded-2xl rounded-bl-sm shadow-sm'} px-4 py-2.5 text-sm">
                                    ${msg.message}
                                </div>
                                <p class="text-xs text-gray-400 mt-1 ${isMine ? 'text-right' : ''}">${time}</p>
                            </div>
                        </div>`;
                }).join('');

                // Hilangkan badge unread
                const badge = document.querySelector(`.unread-badge-${activeUserId}`);
                if (badge) badge.classList.add('hidden');

                if (wasAtBottom || messages.length === 0) {
                    container.scrollTop = container.scrollHeight;
                }
            });
    }

    function sendMessage() {
        const input = document.getElementById('message-input');
        const message = input.value.trim();
        if (!message || !activeUserId) return;

        fetch('/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ?.content || '{{ csrf_token() }}'
            },
            body: JSON.stringify({ receiver_id: activeUserId, message })
        })
        .then(r => r.json())
        .then(() => {
            input.value = '';
            loadMessages();
        });
    }
</script>
</body>
</html>