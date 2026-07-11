<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Owner') — SIMP-PRO</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @php
    $appColor = \App\Models\Setting::get('app_color', '#3b5bdb');
    @endphp
   <style>
        :root {
            --app-color: {{ $appColor }};
        }
    </style>
    <style>
        .nav-item.active {
            background: var(--app-color) !important;
        }

        .icon-btn .badge {
            background: var(--app-color) !important;
        }

        #chat-popup>div:first-child {
            background: var(--app-color) !important;
        }

        .bg-blue-500 {
            background-color: var(--app-color) !important;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: var(--app-color) !important;
            box-shadow: 0 0 0 2px var(--app-color) !important;
        }
    </style>
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #e8eaf0;
        }

        .sidebar {
            width: 200px;
            min-height: 100vh;
            background: #cdd0e3;
            display: flex;
            flex-direction: column;
            padding: 14px 10px;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 50;
        }

        .sidebar .logo-wrap {
            background: white;
            border-radius: 12px;
            padding: 4px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 70px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 500;
            color: #4a4a6a;
            cursor: pointer;
            text-decoration: none;
            margin-bottom: 3px;
            transition: all 0.15s;
            white-space: nowrap;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.55);
            color: #222;
        }

        .nav-item.active {
            background: #3b5bdb;
            color: white !important;
        }

        .nav-item svg {
            width: 15px;
            height: 15px;
            flex-shrink: 0;
        }

        .nav-sub {
            padding-left: 6px;
        }

        .nav-sub .nav-item {
            font-size: 11px;
            padding: 6px 10px;
            border-radius: 16px;
        }

        .user-card {
            margin-top: auto;
            background: rgba(255, 255, 255, 0.45);
            border-radius: 12px;
            padding: 9px 10px;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .main-content {
            margin-left: 200px;
            padding: 18px 22px;
            min-height: 100vh;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .icon-btn {
            position: relative;
            background: white;
            border-radius: 50%;
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            text-decoration: none;
            border: none;
        }

        .icon-btn .badge {
            position: absolute;
            top: -3px;
            right: -3px;
            background: #3b5bdb;
            color: white;
            font-size: 8px;
            border-radius: 50%;
            width: 15px;
            height: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        #chat-popup {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 340px;
            height: 480px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        #chat-popup.hidden {
            display: none;
        }

        #chat-user-list {
            overflow-y: auto;
            flex: 1;
        }

        #chat-messages-area {
            overflow-y: auto;
            flex: 1;
            padding: 12px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
    </style>
    @stack('styles')
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
            confirmButtonColor: '#2563eb'
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: "{{ session('error') }}",
            confirmButtonColor: '#dc2626'
        });
    </script>
    @endif

    @if($errors->any())
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            text: '{{ $errors->first() }}',
            confirmButtonColor: '#f59e0b'
        });
    </script>
    @endif
    @php use Illuminate\Support\Facades\Storage; @endphp

    {{-- CHAT POPUP --}}
    <div id="chat-popup" class="hidden">
        <div class="flex items-center justify-between px-4 py-3 bg-blue-600 text-white flex-shrink-0">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                <span class="text-sm font-semibold" id="chat-popup-title">Chat</span>
            </div>
            <div class="flex items-center gap-2">
                <button id="chat-back-btn" onclick="backToUserList()" class="hidden text-white hover:text-blue-200">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button onclick="closeChatPopup()" class="text-white hover:text-blue-200 text-lg leading-none">✕</button>
            </div>
        </div>
        <div id="chat-user-list">
            <div class="p-3 text-center text-gray-400 text-xs">Memuat daftar user...</div>
        </div>
        <div id="chat-messages-wrap" class="hidden" style="flex:1;display:none;flex-direction:column;overflow:hidden;">
            <div id="chat-messages-area"></div>
            <div class="flex gap-2 px-3 py-2 border-t border-gray-100 flex-shrink-0">
                <input type="text" id="chat-input-msg" placeholder="Tulis pesan..."
                    class="flex-1 border border-gray-200 rounded-xl px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-blue-200"
                    onkeydown="if(event.key==='Enter') sendChatMsg()">
                <button onclick="sendChatMsg()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-xl text-xs font-medium transition">
                    Kirim
                </button>
            </div>
        </div>
    </div>

    {{-- SIDEBAR --}}
    <div class="sidebar">
        <div class="logo-wrap">
            <img src="{{ asset('images/logo_simppro.png') }}" alt="SIMP-PRO" class="h-12 w-full object-contain"
                onerror="this.outerHTML='<span class=\'font-bold text-sm text-blue-800\'>SIMP-PRO</span>'">
        </div>

        <a href="{{ route('owner.dashboard') }}"
            class="nav-item {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            Dashboard
        </a>

        <div>
            <div class="nav-item {{ request()->routeIs('owner.form-pengajuan.*') || request()->routeIs('owner.form-revisi.*') ? 'active' : '' }}"
                onclick="toggleDropdown('review-menu')">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Review Form
                <svg class="ml-auto" style="width:11px;height:11px" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
            <div id="review-menu" class="nav-sub {{ request()->routeIs('owner.form-pengajuan.*') || request()->routeIs('owner.form-revisi.*') ? '' : 'hidden' }}">
                <a href="{{ route('owner.form-pengajuan.index') }}"
                    class="nav-item {{ request()->routeIs('owner.form-pengajuan.*') ? 'active' : '' }}">Form Pengajuan Proyek</a>
                <a href="{{ route('owner.form-revisi.index') }}"
                    class="nav-item {{ request()->routeIs('owner.form-revisi.*') ? 'active' : '' }}">Form Revisi Proyek</a>
            </div>
        </div>

        {{-- Review Kebutuhan Proyek --}}
        <a href="{{ route('owner.kebutuhan.index') }}"
            class="nav-item {{ request()->routeIs('owner.kebutuhan.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Review Kebutuhan
        </a>

        <a href="{{ route('owner.monitoring.index') }}"
            class="nav-item {{ request()->routeIs('owner.monitoring.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Monitoring Proyek
        </a>

        <a href="{{ route('owner.riwayat-keputusan.index') }}"
            class="nav-item {{ request()->routeIs('owner.riwayat-keputusan.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Riwayat Keputusan
        </a>

        <div class="user-card">
            <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : '' }}"
                class="w-8 h-8 rounded-full object-cover flex-shrink-0"
                onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3b5bdb&color=fff&size=32'">
            <div class="overflow-hidden">
                <div class="text-xs font-semibold text-gray-700 truncate">{{ auth()->user()->name }}</div>
                <div class="text-xs text-gray-400 capitalize">{{ auth()->user()->role }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="ml-auto flex-shrink-0">
                @csrf
                <button type="submit" title="Logout" class="text-gray-400 hover:text-red-500">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    {{-- MAIN --}}
    <div class="main-content">
        <div class="topbar">
            <h1 class="text-base font-semibold text-gray-500">@yield('page-title')</h1>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="icon-btn" onclick="toggleNotif()" id="notif-btn">
                        <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="badge hidden" id="notif-badge">0</span>
                    </div>
                    <div id="notif-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-lg z-50 overflow-hidden">
                        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Notifikasi</span>
                            <button onclick="markAllRead()" class="text-xs text-blue-600 hover:underline">Tandai semua dibaca</button>
                        </div>
                        <div id="notif-list" class="max-h-72 overflow-y-auto">
                            <p class="text-center text-gray-400 text-xs py-6">Tidak ada notifikasi</p>
                        </div>
                    </div>
                </div>
                <div class="icon-btn relative" onclick="toggleChatPopup()">
                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    <span class="badge hidden" id="chat-badge">0</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-600">Hello, {{ auth()->user()->name }}</span>
                    <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : '' }}"
                        class="w-8 h-8 rounded-full object-cover"
                        onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3b5bdb&color=fff&size=32'">
                </div>
            </div>
        </div>
        @yield('content')
    </div>

    <script>
        const myId = {{ auth()->id() }};
        let activeChatUserId = null;
        let chatPollingInterval = null;

        function toggleDropdown(id) {
            document.getElementById(id).classList.toggle('hidden');
        }

        document.addEventListener('click', function(e) {
            const btn = document.getElementById('notif-btn');
            const dropdown = document.getElementById('notif-dropdown');
            if (btn && !btn.contains(e.target) && dropdown && !dropdown.contains(e.target)) dropdown.classList.add('hidden');
        });

        function toggleNotif() {
            document.getElementById('notif-dropdown').classList.toggle('hidden');
            loadNotifications();
        }

        function loadNotifications() {
            fetch('/notifications').then(r => r.json()).then(data => {
                const list = document.getElementById('notif-list');
                if (data.length === 0) {
                    list.innerHTML = '<p class="text-center text-gray-400 text-xs py-6">Tidak ada notifikasi</p>';
                    return;
                }
                list.innerHTML = data.map(n => `<div class="px-4 py-3 border-b border-gray-50 ${n.is_read ? '' : 'bg-blue-50'} ${n.url ? 'cursor-pointer hover:bg-gray-100' : ''}" ${n.url ? `onclick="window.location.href='${n.url}'"` : ''}><p class="text-xs font-semibold text-gray-700">${n.title}</p><p class="text-xs text-gray-500 mt-0.5">${n.message}</p><p class="text-xs text-gray-400 mt-1">${new Date(n.created_at).toLocaleString('id-ID')}</p>${n.url ? '<p class="text-xs text-blue-500 mt-1">Klik untuk lihat →</p>' : ''}</div>`).join('');
            });
        }

        function markAllRead() {
            fetch('/notifications/read-all', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(() => {
                    loadNotifications();
                    document.getElementById('notif-badge').classList.add('hidden');
                });
        }

        function toggleChatPopup() {
            const popup = document.getElementById('chat-popup');
            if (popup.classList.contains('hidden')) {
                popup.classList.remove('hidden');
                loadChatUsers();
            } else {
                closeChatPopup();
            }
        }

        function closeChatPopup() {
            document.getElementById('chat-popup').classList.add('hidden');
            if (chatPollingInterval) clearInterval(chatPollingInterval);
            activeChatUserId = null;
        }

        function loadChatUsers() {
            fetch('/chat/users').then(r => r.json()).then(users => {
                const list = document.getElementById('chat-user-list');
                if (users.length === 0) {
                    list.innerHTML = '<p class="text-center text-gray-400 text-xs py-6">Tidak ada user.</p>';
                    return;
                }
                list.innerHTML = users.map(u => `
            <div onclick="openChatWith(${u.id}, '${u.name}')" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-50 transition">
                <img src="${u.avatar_url || ''}" class="w-8 h-8 rounded-full object-cover flex-shrink-0" onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(u.name)}&background=3b5bdb&color=fff&size=32'">
                <div><p class="text-xs font-medium text-gray-700">${u.name}</p><p class="text-xs text-gray-400 capitalize">${u.role}</p></div>
                ${u.unread > 0 ? `<span class="ml-auto bg-blue-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">${u.unread}</span>` : ''}
            </div>`).join('');
            });
        }

        function openChatWith(userId, userName) {
            activeChatUserId = userId;
            document.getElementById('chat-popup-title').textContent = userName;
            document.getElementById('chat-back-btn').classList.remove('hidden');
            document.getElementById('chat-user-list').classList.add('hidden');
            const wrap = document.getElementById('chat-messages-wrap');
            wrap.classList.remove('hidden');
            wrap.style.display = 'flex';
            wrap.style.flexDirection = 'column';
            wrap.style.flex = '1';
            wrap.style.overflow = 'hidden';
            loadChatMessages();
            if (chatPollingInterval) clearInterval(chatPollingInterval);
            chatPollingInterval = setInterval(loadChatMessages, 2000);
        }

        function backToUserList() {
            if (chatPollingInterval) clearInterval(chatPollingInterval);
            activeChatUserId = null;
            document.getElementById('chat-popup-title').textContent = 'Chat';
            document.getElementById('chat-back-btn').classList.add('hidden');
            document.getElementById('chat-user-list').classList.remove('hidden');
            const wrap = document.getElementById('chat-messages-wrap');
            wrap.classList.add('hidden');
            wrap.style.display = 'none';
            loadChatUsers();
        }

        function loadChatMessages() {
            if (!activeChatUserId) return;
            fetch(`/chat/messages/${activeChatUserId}`).then(r => r.json()).then(messages => {
                const area = document.getElementById('chat-messages-area');
                const wasAtBottom = area.scrollHeight - area.clientHeight <= area.scrollTop + 10;
                area.innerHTML = messages.map(msg => {
                    const isMine = msg.sender_id === myId;
                    const time = new Date(msg.created_at).toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    return `<div style="display:flex;justify-content:${isMine ? 'flex-end' : 'flex-start'}"><div><div style="background:${isMine ? '#3b5bdb' : '#f3f4f6'};color:${isMine ? 'white' : '#374151'};padding:6px 10px;border-radius:12px;font-size:11px;max-width:200px;word-break:break-word;">${msg.message}</div><p style="font-size:9px;color:#9ca3af;margin-top:2px;text-align:${isMine ? 'right' : 'left'}">${time}</p></div></div>`;
                }).join('');
                if (wasAtBottom) area.scrollTop = area.scrollHeight;
            });
        }

        function sendChatMsg() {
            const input = document.getElementById('chat-input-msg');
            const message = input.value.trim();
            if (!message || !activeChatUserId) return;
            fetch('/chat/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        receiver_id: activeChatUserId,
                        message
                    })
                })
                .then(() => {
                    input.value = '';
                    loadChatMessages();
                });
        }

        function pollBadges() {
            fetch('/notifications/unread').then(r => r.json()).then(data => {
                const badge = document.getElementById('notif-badge');
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            });
            fetch('/chat/unread').then(r => r.json()).then(data => {
                const badge = document.getElementById('chat-badge');
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            });
        }

        pollBadges();
        setInterval(pollBadges, 5000);
    </script>
    @stack('scripts')
</body>

</html>