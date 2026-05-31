@extends('admin.layout.app')
@php use Illuminate\Support\Facades\Storage; @endphp

@section('title', 'Kelola User')
@section('page-title', 'Kelola User')

@section('content')

<div class="bg-white rounded-2xl shadow-sm p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-5">KELOLA USER</h2>

    {{-- Search --}}
    <div class="relative mb-5">
        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </span>
        <input type="text" id="searchInput" placeholder="Cari User"
               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
               onkeyup="filterTable()">
    </div>

    {{-- Tabel --}}
    <div class="rounded-xl overflow-hidden border border-gray-100">
        <table class="w-full text-sm" id="userTable">
            <tbody>
                @forelse($users as $user)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-gray-400 w-8">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $user->avatar ? Storage::url($user->avatar) : '' }}"
                                 class="w-8 h-8 rounded-full object-cover"
                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=3b5bdb&color=fff&size=32'">
                            <span class="font-medium text-gray-700">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $user->email }}</td>
                    <td class="px-4 py-3">
                        @if($user->is_active)
                            <span class="bg-green-100 text-green-600 text-xs font-semibold px-3 py-1 rounded-full">Active</span>
                        @else
                            <span class="bg-red-100 text-red-500 text-xs font-semibold px-3 py-1 rounded-full">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-600 capitalize">{{ $user->role }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.user.edit', $user->id) }}"
                               class="text-blue-400 hover:text-blue-600">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.user.destroy', $user->id) }}"
                                  onsubmit="return confirm('Yakin hapus user ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-8 text-gray-400">Belum ada user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
function filterTable() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#userTable tbody tr');
    rows.forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(input) ? '' : 'none';
    });
}
</script>
@endpush