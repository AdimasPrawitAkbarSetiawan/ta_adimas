@extends('klien.layouts.app')

@section('title', 'Progres Proyek')
@section('judul-halaman', 'Monitoring Klien')

@section('konten')

<div class="bg-white rounded-2xl shadow-sm p-6">

    @if($proyek->isEmpty())
        <div class="text-center py-16 text-gray-400">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-sm">Belum ada proyek yang terdaftar.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($proyek as $p)
            <div class="border border-gray-100 rounded-2xl p-5 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h3 class="font-bold text-gray-800">{{ $p->name }}</h3>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $p->project_code }}</p>
                    </div>
                    @php
                        $badge = match($p->status) {
                            'draft'       => ['bg-gray-100 text-gray-500', 'Draft'],
                            'review'      => ['bg-yellow-100 text-yellow-600', 'Menunggu Review'],
                            'revision'    => ['bg-orange-100 text-orange-600', 'Revisi'],
                            'approved'    => ['bg-blue-100 text-blue-600', 'Disetujui'],
                            'in_progress' => ['bg-purple-100 text-purple-600', 'Sedang Berjalan'],
                            'completed'   => ['bg-green-100 text-green-600', 'Selesai'],
                            'rejected'    => ['bg-red-100 text-red-500', 'Ditolak'],
                            default       => ['bg-gray-100 text-gray-500', $p->status],
                        };
                    @endphp
                    <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $badge[0] }}">{{ $badge[1] }}</span>
                </div>

                {{-- Progress bar --}}
                @php $persentase = $p->latestProgress?->percentage ?? 0; @endphp
                <div class="mb-3">
                    <div class="flex justify-between text-xs text-gray-500 mb-1">
                        <span>Progres Pekerjaan</span>
                        <span>{{ $persentase }}%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $persentase }}%"></div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <p class="text-xs text-gray-400">{{ $p->location ?? '-' }}</p>
                    @if(in_array($p->status, ['in_progress', 'completed', 'approved']))
                    <a href="{{ route('klien.progres.show', $p->id) }}"
                       class="text-xs bg-blue-500 text-white px-4 py-1.5 rounded-full hover:bg-blue-600 font-medium">
                        Lihat Detail
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif

</div>

@endsection