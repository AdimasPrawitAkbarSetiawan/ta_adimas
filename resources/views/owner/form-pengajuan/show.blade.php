@extends('owner.layouts.app')

@section('title', 'Detail Pengajuan')
@section('page-title', 'Review Form Cek Owner')

@section('content')

<div class="grid grid-cols-2 gap-5">

    {{-- KIRI --}}
    <div class="space-y-4">

        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-4">Detail Pengajuan</h3>

            <div class="flex items-center gap-3 mb-4">
                <img src="" class="w-10 h-10 rounded-full object-cover"
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($project->marketing->name ?? "M") }}&background=3b5bdb&color=fff&size=40'">
                <div>
                    <div class="text-sm font-semibold text-gray-700">{{ $project->marketing->name ?? '-' }} (Marketing)</div>
                    <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($project->created_at)->translatedFormat('d F Y') }}</div>
                </div>
            </div>

            <div class="space-y-3">
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Judul Proyek :</label>
                    <div class="border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 bg-gray-50">{{ $project->name }}</div>
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Lokasi Proyek :</label>
                    <div class="border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 bg-gray-50">{{ $project->location ?? '-' }}</div>
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Deskripsi Proyek :</label>
                    <div class="border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 bg-gray-50 min-h-20">{{ $project->description }}</div>
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Estimasi Anggaran :</label>
                    <div class="border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 bg-gray-50">
                        Rp {{ number_format($project->budget_estimate, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>

        @if($project->other_info)
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-3">Informasi Lainnya</h3>
            <p class="text-sm text-gray-600 leading-relaxed">{{ $project->other_info }}</p>
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-3">Saran atau Masukan</h3>
            <textarea name="note" id="note" rows="3"
                      placeholder="Berikan Komentar (Opsional)"
                      class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 resize-none"></textarea>
        </div>

    </div>

    {{-- KANAN --}}
    <div class="space-y-4">

        {{-- Dokumentasi Foto --}}
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-3">Dokumentasi Proyek</h3>
            @php
                $foto = null;
                foreach($project->progress as $p) {
                    if($p->photos->first()) { $foto = $p->photos->first(); break; }
                }
            @endphp
            @if($foto)
                <img src="{{ asset('storage/'.$foto->file_path) }}"
                     class="w-full h-48 object-cover rounded-xl">
            @else
                <div class="w-full h-48 bg-gray-100 rounded-xl flex items-center justify-center text-gray-300">
                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif
        </div>

        {{-- Link Google Maps --}}
        @if($project->maps_link)
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-blue-500 mb-3">Link Google Maps</h3>
            <a href="{{ $project->maps_link }}" target="_blank"
               class="flex items-center gap-2 text-blue-500 hover:text-blue-700 text-sm">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ $project->maps_link }}
            </a>
        </div>
        @endif

        {{-- Riwayat Pengajuan --}}
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-3">Riwayat Pengajuan</h3>
            <div class="flex items-center gap-3">
                <img src="" class="w-10 h-10 rounded-full"
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($project->marketing->name ?? "M") }}&background=3b5bdb&color=fff&size=40'">
                <div>
                    <div class="text-sm font-semibold text-gray-700">{{ $project->marketing->name ?? '-' }} Mengajukan Proyek Ini</div>
                    <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($project->created_at)->translatedFormat('d F Y') }}</div>
                </div>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex gap-3">
            <form method="POST" action="{{ route('owner.form-pengajuan.reject', $project->id) }}" class="flex-1">
                @csrf
                <input type="hidden" name="note" id="note-reject">
                <button type="submit"
                        class="w-full py-3 bg-red-500 text-white rounded-xl font-semibold hover:bg-red-600 transition"
                        onclick="document.getElementById('note-reject').value = document.getElementById('note').value">
                    Tolak Proyek
                </button>
            </form>

            <form method="POST" action="{{ route('owner.form-pengajuan.revisi', $project->id) }}" class="flex-1">
                @csrf
                <input type="hidden" name="note" id="note-revisi">
                <button type="submit"
                        class="w-full py-3 bg-yellow-400 text-white rounded-xl font-semibold hover:bg-yellow-500 transition"
                        onclick="document.getElementById('note-revisi').value = document.getElementById('note').value">
                    Revisi Proyek
                </button>
            </form>

            <form method="POST" action="{{ route('owner.form-pengajuan.approve', $project->id) }}" class="flex-1">
                @csrf
                <input type="hidden" name="note" id="note-approve">
                <button type="submit"
                        class="w-full py-3 bg-green-500 text-white rounded-xl font-semibold hover:bg-green-600 transition"
                        onclick="document.getElementById('note-approve').value = document.getElementById('note').value">
                    Setujui Proyek
                </button>
            </form>
        </div>

    </div>
</div>

@endsection