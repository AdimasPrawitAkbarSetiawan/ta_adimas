@extends('owner.layouts.app')
@section('title', 'Monitoring Proyek')
@section('page-title', 'Monitoring Owner')

@section('content')

<div class="bg-white rounded-2xl shadow-sm p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-5">MONITORING PROYEK</h2>

    <div class="relative mb-5">
        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
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
                    <th class="px-4 py-3 text-left">Progres</th>
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
                        @php
                        $badge = match($project->status) {
                        'approved' => ['bg-blue-100 text-blue-600', 'Disetujui'],
                        'in_progress' => ['bg-purple-100 text-purple-600', 'Berjalan'],
                        'pending_detail' => ['bg-orange-100 text-orange-600', 'Review Kebutuhan'],
                        'completed' => ['bg-green-100 text-green-600', 'Selesai'],
                        default => ['bg-gray-100 text-gray-500', $project->status],
                        };
                        @endphp
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $badge[0] }}">{{ $badge[1] }}</span>
                    </td>
                    <td class="px-4 py-3">
                        @php $pct = $project->latestProgress?->percentage ?? 0; @endphp
                        <div class="flex items-center gap-2">
                            <div class="w-20 bg-gray-200 rounded-full h-1.5">
                                <div class="bg-blue-500 h-1.5 rounded-full" style="width:{{ $pct }}%"></div>
                            </div>
                            <span class="text-xs text-gray-500">{{ $pct }}%</span>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                    @if($project->status === 'pending_detail')
                    <span class="text-gray-400 text-xs">Lihat di menu Review Kebutuhan</span>
                    @else
                    <a href="{{ route('owner.monitoring.show', $project->id) }}"
                        class="text-blue-500 hover:text-blue-700 text-xs font-medium">
                        Detail
                    </a>
                    @endif
                </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-8 text-gray-400">Belum ada proyek.</td>
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