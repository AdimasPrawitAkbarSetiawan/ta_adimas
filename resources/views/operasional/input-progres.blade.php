@extends('operasional.layouts.app')

@section('title', 'Input Progres Proyek')
@section('judul-halaman', 'Input Progres Proyek')

@section('konten')

<div class="grid grid-cols-2 gap-5">

    {{-- KIRI: Form --}}
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h3 class="font-bold text-gray-800 mb-4">Tambah Progres Proyek</h3>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg px-4 py-3 mb-4">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('operasional.input-progres.store', $project->id) }}"
              enctype="multipart/form-data">
        @csrf

            <div class="space-y-4">
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Nama Proyek :</label>
                    <div class="border border-gray-100 bg-gray-50 rounded-lg px-3 py-2 text-sm text-gray-700">
                        {{ $project->name }}
                    </div>
                </div>

                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Judul Progres :</label>
                    <input type="text" name="judul" placeholder="Contoh: Minggu 1 - Persiapan Lahan"
                           value="{{ old('judul') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 @error('judul') border-red-400 @enderror">
                    @error('judul')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Tanggal Laporan :</label>
                    <input type="date" name="tanggal_laporan"
                           value="{{ old('tanggal_laporan', now()->format('Y-m-d')) }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 @error('tanggal_laporan') border-red-400 @enderror">
                    @error('tanggal_laporan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Persentase Progres :</label>
                    <div class="relative">
                        <input type="number" name="persentase" min="0" max="100" placeholder="0 - 100"
                               value="{{ old('persentase') }}"
                               class="w-full border border-gray-200 rounded-lg px-3 pr-8 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 @error('persentase') border-red-400 @enderror"
                               oninput="perbaruiProgres(this.value)">
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">%</span>
                    </div>
                    <div class="mt-2 bg-gray-100 rounded-full h-2">
                        <div id="bilahProgres" class="bg-blue-500 h-2 rounded-full transition-all" style="width:0%"></div>
                    </div>
                    @error('persentase')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Keterangan Progres :</label>
                    <textarea name="keterangan" rows="4" placeholder="Jelaskan pekerjaan yang telah dilakukan..."
                              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 resize-none @error('keterangan') border-red-400 @enderror">{{ old('keterangan') }}</textarea>
                    @error('keterangan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Upload Gambar Progres Proyek :</label>
                    <label for="foto"
                           class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 overflow-hidden">
                        <div id="area-pratinjau" class="flex flex-col items-center justify-center text-gray-400 w-full h-full">
                            <svg class="w-8 h-8 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-xs">Pilih Foto (bisa lebih dari 1)</span>
                        </div>
                        <input type="file" id="foto" name="foto[]" accept="image/*" multiple class="hidden"
                               onchange="pratinjauFoto(event)">
                    </label>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('operasional.proyek-berjalan.index') }}"
                       class="px-5 py-2 bg-red-500 text-white rounded-lg text-sm font-semibold hover:bg-red-600">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-5 py-2 bg-green-500 text-white rounded-lg text-sm font-semibold hover:bg-green-600">
                        Update Progres
                    </button>
                </div>
            </div>

        </form>
    </div>

    {{-- KANAN: Foto Proyek --}}
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h3 class="font-bold text-gray-800 mb-3">Foto Proyek Terkini</h3>
        @if($project->progress->last()?->photos->first())
            <img src="{{ asset('storage/'.$project->progress->last()->photos->first()->file_path) }}"
                 class="w-full h-64 object-cover rounded-xl">
        @else
            <div class="w-full h-64 bg-gray-100 rounded-xl flex items-center justify-center text-gray-300">
                <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif

        @if($project->progress->count() > 0)
        <div class="mt-4">
            <h4 class="font-semibold text-sm text-gray-700 mb-3">Riwayat Progres</h4>
            <div class="space-y-3 max-h-48 overflow-y-auto">
                @foreach($project->progress->sortByDesc('created_at') as $progres)
                <div class="flex items-center gap-3 border-b border-gray-50 pb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-xs font-bold text-blue-600">{{ $progres->percentage }}%</span>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-700">{{ $progres->title }}</p>
                        <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($progres->tanggal_laporan ?? $progres->created_at)->format('d M Y') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

</div>

@endsection

@push('scripts')
<script>
function perbaruiProgres(nilai) {
    document.getElementById('bilahProgres').style.width = nilai + '%';
}

function pratinjauFoto(event) {
    const berkas = event.target.files;
    if (!berkas.length) return;
    const area = document.getElementById('area-pratinjau');
    area.innerHTML = '';
    area.className = 'grid grid-cols-3 gap-1 w-full h-full p-1';
    Array.from(berkas).slice(0, 6).forEach(b => {
        const pembaca = new FileReader();
        pembaca.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'w-full h-20 object-cover rounded';
            area.appendChild(img);
        };
        pembaca.readAsDataURL(b);
    });
}
</script>
@endpush