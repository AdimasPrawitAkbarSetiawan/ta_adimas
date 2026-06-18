@extends('owner.layouts.app')

@section('title', 'Review Kebutuhan Proyek')
@section('page-title', 'Review Kebutuhan Proyek')

@section('content')

<div class="bg-white rounded-2xl shadow-sm p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-5">REVIEW KEBUTUHAN PROYEK</h2>

    <div class="relative mb-5">
        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </span>
        <input type="text" id="cariProyek" placeholder="Cari Proyek..."
               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
               onkeyup="cariTabel()">
    </div>

    <div class="rounded-xl overflow-hidden border border-gray-100">
        <table class="w-full text-sm" id="tabelProyek">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs">
                    <th class="px-4 py-3 text-left w-8">No</th>
                    <th class="px-4 py-3 text-left">Nama Proyek</th>
                    <th class="px-4 py-3 text-left">Klien</th>
                    <th class="px-4 py-3 text-left">Marketing</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-gray-400">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 font-medium text-gray-700">{{ $project->name }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $project->klien->user->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $project->marketing->name ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-orange-100 text-orange-600">
                            Menunggu Review
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('owner.kebutuhan.show', $project->id) }}"
                           class="text-blue-500 hover:text-blue-700 text-xs font-medium">
                            Review
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-8 text-gray-400">Tidak ada kebutuhan proyek yang perlu direview.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
function cariTabel() {
    const input = document.getElementById('cariProyek').value.toLowerCase();
    const rows = document.querySelectorAll('#tabelProyek tbody tr');
    rows.forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(input) ? '' : 'none';
    });
}
</script>
@endpush