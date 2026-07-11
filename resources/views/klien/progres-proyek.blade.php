@extends('klien.layouts.app')

@section('title', 'Detail Progres Proyek')
@section('judul-halaman', 'Monitoring Klien')

@section('konten')

{{-- Lightbox Modal --}}
<div id="lightbox" class="fixed inset-0 bg-black bg-opacity-80 z-50 hidden flex items-center justify-center p-4" onclick="closeLightbox()">
    <div class="relative max-w-4xl w-full">
        <button onclick="closeLightbox()" class="absolute -top-10 right-0 text-white text-sm hover:text-gray-300">✕ Tutup</button>
        <img id="lightbox-img" src="" class="w-full max-h-screen object-contain rounded-xl">
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm p-6">

    {{-- Breadcrumb --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-2 text-sm">
            <a href="{{ route('klien.dashboard') }}" class="text-gray-400 hover:text-blue-500">
                <svg class="w-4 h-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                PROGRES PROYEK
            </a>
            <span class="text-gray-400">/</span>
            <span class="font-semibold text-gray-700 uppercase">{{ $project->name }}</span>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('klien.progres.cetak', $project->id) }}"
               target="_blank"
               class="flex items-center gap-1 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4H7v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                CETAK PDF
            </a>
            <a href="{{ route('klien.dashboard') }}"
               class="flex items-center gap-1 px-4 py-2 bg-red-500 text-white rounded-lg text-sm font-semibold hover:bg-red-600">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                KEMBALI
            </a>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6">

        {{-- KIRI --}}
        <div>
            {{-- Foto Proyek Terbaru --}}
            <div class="rounded-xl overflow-hidden bg-gray-100 mb-4 h-52 cursor-pointer relative"
                 onclick="openLightbox(this.querySelector('img')?.src)">
                @if($project->progress->last()?->photos->first())
                    <img src="{{ asset('storage/'.$project->progress->last()->photos->first()->file_path) }}"
                         class="w-full h-full object-cover hover:opacity-90 transition"
                         title="Klik untuk perbesar">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Rincian Proyek --}}
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold text-sm text-gray-700 mb-3">Rincian Proyek</h3>
                @if($project->detail)
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $project->detail->scope_of_work }}</p>
                @else
                    <p class="text-sm text-gray-400">Belum ada rincian proyek.</p>
                @endif
            </div>
        </div>

        {{-- KANAN --}}
        <div>
            <div class="bg-gray-50 rounded-xl p-4 h-full overflow-y-auto max-h-96">
                <h3 class="font-semibold text-sm text-gray-700 mb-3 flex items-center gap-1">
                    <span>📊</span> UPDATE PROGRES PROYEK
                </h3>
                <p class="text-xs text-gray-500 mb-3">Proyek: {{ $project->name }}</p>

                @forelse($project->progress->sortByDesc('tanggal_laporan') as $progres)
                    <div class="mb-5 border-b border-gray-200 pb-4 last:border-0">
                        <p class="text-xs font-semibold text-gray-600 mb-1">
                            📅 {{ $progres->title }} (Progres {{ $progres->percentage }}%)
                        </p>
                        <p class="text-xs text-gray-500 leading-relaxed mb-2">{{ $progres->description }}</p>

                        {{-- Foto per progres --}}
                        @if($progres->photos->count() > 0)
                            <div class="flex flex-wrap gap-2 mt-2">
                                @foreach($progres->photos as $foto)
                                    <img src="{{ asset('storage/'.$foto->file_path) }}"
                                         class="w-16 h-16 object-cover rounded-lg cursor-pointer hover:opacity-80 transition border border-gray-200"
                                         onclick="openLightbox(this.src)"
                                         title="Klik untuk perbesar">
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-gray-400">Belum ada update progres.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
function openLightbox(src) {
    if (!src) return;
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox').classList.remove('hidden');
    document.getElementById('lightbox').classList.add('flex');
}

function closeLightbox() {
    document.getElementById('lightbox').classList.add('hidden');
    document.getElementById('lightbox').classList.remove('flex');
    document.getElementById('lightbox-img').src = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeLightbox();
});
</script>
@endpush