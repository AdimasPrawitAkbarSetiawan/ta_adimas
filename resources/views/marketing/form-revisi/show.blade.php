@extends('marketing.layouts.app')

@section('title', 'Detail Revisi')
@section('page-title', 'Review Form Cek Marketing')

@section('content')

<div class="grid grid-cols-2 gap-5">

    {{-- KIRI --}}
    <div class="space-y-4">

        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-4">Detail Pengajuan yang Direvisi</h3>

            <div class="flex items-center gap-3 mb-4">
                <img src="" class="w-10 h-10 rounded-full"
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3b5bdb&color=fff&size=40'">
                <div>
                    <div class="text-sm font-semibold text-gray-700">{{ auth()->user()->name }} (Marketing)</div>
                    <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($project->created_at)->translatedFormat('d F Y') }}</div>
                </div>
            </div>

            <div class="space-y-3">
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Judul Proyek :</label>
                    <div class="border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50">{{ $project->name }}</div>
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Lokasi Proyek :</label>
                    <div class="border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50">{{ $project->location ?? '-' }}</div>
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Deskripsi Proyek :</label>
                    <div class="border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 min-h-20">{{ $project->description }}</div>
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Estimasi Anggaran :</label>
                    <div class="border border-red-300 rounded-lg px-3 py-2 text-sm bg-gray-50 flex items-center justify-between">
                        Rp. {{ number_format($project->budget_estimate, 0, ',', '.') }}
                        <svg class="w-4 h-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        @if($project->detail)
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-3">Informasi Lainnya</h3>
            <p class="text-sm text-gray-600 leading-relaxed">{{ $project->detail->scope_of_work }}</p>
        </div>
        @endif

        {{-- Catatan dari Owner --}}
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-3">Saran atau Masukan</h3>
            @foreach($project->notes->where('type', 'revision') as $note)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg px-3 py-2 text-sm text-yellow-700 mb-2">
                    {{ $note->note }}
                </div>
            @endforeach
        </div>

    </div>

    {{-- KANAN --}}
    <div class="space-y-4">

        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-3">Dokumentasi Proyek</h3>
            @if($project->progress->first()?->photos->first())
                <img src="{{ asset('storage/'.$project->progress->first()->photos->first()->file_path) }}"
                     class="w-full h-48 object-cover rounded-xl">
            @else
                <div class="w-full h-48 bg-gray-100 rounded-xl flex items-center justify-center text-gray-300">
                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif
        </div>

        @if($project->maps_link)
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <a href="{{ $project->maps_link }}" target="_blank"
               class="text-blue-500 text-sm hover:underline">{{ $project->maps_link }}</a>
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-3">Riwayat Pengajuan</h3>
            <div class="flex items-center gap-3">
                <img src="" class="w-10 h-10 rounded-full"
                     onerror="this.src='https://ui-avatars.com/api/?name=Owner&background=ef4444&color=fff&size=40'">
                <div>
                    <div class="text-sm font-semibold text-gray-700">Owner Merevisi Proyek ini</div>
                    <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($project->updated_at)->translatedFormat('d F Y') }}</div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('marketing.form-revisi.kirim', $project->id) }}">
            @csrf
            <button type="submit"
                    class="w-full py-3 bg-green-500 text-white rounded-xl font-semibold hover:bg-green-600 transition text-sm">
                Kirim Kembali Form
            </button>
        </form>

    </div>
</div>

@endsection