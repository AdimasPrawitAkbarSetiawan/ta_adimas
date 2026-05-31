@extends('marketing.layouts.app')

@section('title', 'Riwayat Pengajuan')
@section('page-title', 'Review Form Pengajuan Marketing')

@section('content')

<div class="bg-white rounded-2xl shadow-sm p-6">

    <div class="relative mb-5">
        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </span>
        <input type="text" id="searchInput" placeholder="Cari Form Pengajuan"
               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
               onkeyup="filterTable()">
    </div>

    <div class="rounded-xl overflow-hidden border border-gray-100">
        <table class="w-full text-sm" id="projectTable">
            <tbody>
                @forelse($projects as $project)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-gray-400 w-8">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <img src="" class="w-8 h-8 rounded-full"
                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($project->klien->user->name ?? "K") }}&background=10b981&color=fff&size=32'">
                            <span class="font-medium text-gray-700">{{ $project->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $project->klien->user->name ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @php
                            $badge = match($project->status) {
                                'draft'       => ['bg-gray-100 text-gray-500', 'Draft'],
                                'review'      => ['bg-teal-500 text-white', 'Belum di Cek'],
                                'revision'    => ['bg-yellow-400 text-white', 'Direvisi'],
                                'approved'    => ['bg-green-500 text-white', 'Disetujui'],
                                'in_progress' => ['bg-blue-500 text-white', 'Berjalan'],
                                'completed'   => ['bg-green-600 text-white', 'Selesai'],
                                'rejected'    => ['bg-red-500 text-white', 'Ditolak'],
                                default       => ['bg-gray-100 text-gray-500', $project->status],
                            };
                        @endphp
                        <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $badge[0] }}">{{ $badge[1] }}</span>
                    </td>
                    <td class="px-4 py-3 text-gray-500 text-xs">{{ \Carbon\Carbon::parse($project->created_at)->format('d-m-Y') }}</td>
                    <td class="px-4 py-3">
                        @if($project->status === 'revision')
                        <a href="{{ route('marketing.form-revisi.show', $project->id) }}"
                           class="bg-blue-100 text-blue-600 text-xs font-semibold px-3 py-1 rounded-full hover:bg-blue-200">Cek</a>
                        @else
                        <span class="text-xs text-gray-300 px-3 py-1">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-8 text-gray-400">Belum ada riwayat pengajuan.</td>
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
    const rows = document.querySelectorAll('#projectTable tbody tr');
    rows.forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(input) ? '' : 'none';
    });
}
</script>
@endpush