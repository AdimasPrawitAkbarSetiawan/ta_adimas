@extends('operasional.layouts.app')

@section('title', 'Kebutuhan Direvisi')
@section('judul-halaman', 'Kebutuhan Proyek yang Direvisi Owner')

@section('konten')

<div class="bg-white rounded-2xl shadow-sm p-6">

    @if(session('sukses'))
        <div class="bg-green-50 border border-green-200 text-green-600 text-sm rounded-lg px-4 py-3 mb-4">
            {{ session('sukses') }}
        </div>
    @endif

    <div class="relative mb-5">
        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </span>
        <input type="text" id="cariProyek" placeholder="Cari Proyek"
               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
               onkeyup="cariTabel()">
    </div>

    <div class="space-y-3" id="tabelProyek">
        @forelse($daftar as $proyek)
            @php
                $catatan = $proyek->notes
                    ->where('type', 'revision_kebutuhan')
                    ->sortByDesc('created_at')
                    ->first();
            @endphp
            <div class="border border-orange-200 bg-orange-50 rounded-xl p-4">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-start gap-3">
                        <img src="" class="w-9 h-9 rounded-full mt-0.5"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($proyek->name) }}&background=f97316&color=fff&size=36'">
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">{{ $proyek->name }}</p>
                            <p class="text-xs text-gray-500 mb-2">{{ $proyek->location ?? '-' }}</p>
                            @if($catatan)
                                <div class="bg-white border border-orange-200 rounded-lg px-3 py-2 text-xs text-orange-700">
                                    <span class="font-semibold">Catatan revisi dari Owner:</span><br>
                                    {{ $catatan->note }}
                                </div>
                            @else
                                <p class="text-xs text-gray-400 italic">Tidak ada catatan revisi.</p>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('operasional.input-kebutuhan.show', $proyek->id) }}"
                       class="bg-orange-500 text-white text-xs font-semibold px-4 py-2 rounded-full hover:bg-orange-600 whitespace-nowrap">
                        Perbaiki Kebutuhan
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-400 text-sm">
                Tidak ada kebutuhan proyek yang perlu direvisi saat ini.
            </div>
        @endforelse
    </div>

</div>

@endsection

@push('scripts')
<script>
function cariTabel() {
    const input = document.getElementById('cariProyek').value.toLowerCase();
    document.querySelectorAll('#tabelProyek > div').forEach(el => {
        el.style.display = el.textContent.toLowerCase().includes(input) ? '' : 'none';
    });
}
</script>
@endpush