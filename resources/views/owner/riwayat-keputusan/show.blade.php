@extends('owner.layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
    <a href="{{ route('owner.riwayat-keputusan.index') }}"
       class="text-sm text-blue-600 hover:underline mb-4 inline-block">
        ← Kembali
    </a>

    <div class="bg-white rounded-xl shadow p-6 space-y-4">
        <h1 class="text-xl font-bold text-gray-800">{{ $project->name }}</h1>
        <p class="text-sm text-gray-500">{{ $project->project_code }}</p>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Klien</p>
                <p class="font-medium">{{ $project->klien->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Marketing</p>
                <p class="font-medium">{{ $project->marketing->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Estimasi Anggaran</p>
                <p class="font-medium">Rp {{ number_format($project->budget_estimate, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-gray-500">Status</p>
                @php
                    $badge = match($project->status) {
                        'approved' => 'bg-green-100 text-green-700',
                        'rejected' => 'bg-red-100 text-red-700',
                        'revision' => 'bg-yellow-100 text-yellow-700',
                        default    => 'bg-gray-100 text-gray-600',
                    };
                    $label = match($project->status) {
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'revision' => 'Revisi',
                        default    => $project->status,
                    };
                @endphp
                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ $label }}</span>
            </div>
        </div>

        {{-- Catatan / Notes --}}
        @if($project->notes->count())
        <div class="mt-4">
            <h2 class="font-semibold text-gray-700 mb-2">Catatan Keputusan</h2>
            <ul class="space-y-2">
                @foreach($project->notes as $note)
                <li class="bg-gray-50 rounded-lg p-3 text-sm text-gray-700">
                    <p>{{ $note->note }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $note->created_at->format('d M Y, H:i') }}</p>
                </li>
                @endforeach
            </ul>
        </div>
        @else
        <p class="text-sm text-gray-400 mt-4">Tidak ada catatan untuk proyek ini.</p>
        @endif
    </div>
</div>
@endsection