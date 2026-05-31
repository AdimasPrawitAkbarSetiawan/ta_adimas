@extends('marketing.layouts.app')

@section('title', 'Form Pengajuan')
@section('page-title', 'Form Pengajuan Marketing')

@section('content')

<div class="grid grid-cols-2 gap-5">

    {{-- KIRI --}}
    <form method="POST" action="{{ route('marketing.form-pengajuan.store') }}" enctype="multipart/form-data" id="formPengajuan">
    @csrf

    <div class="space-y-4">

        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-4">Detail Pengajuan</h3>

            <div class="flex items-center gap-3 mb-4">
                <img src="" class="w-10 h-10 rounded-full"
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3b5bdb&color=fff&size=40'">
                <div>
                    <div class="text-sm font-semibold text-gray-700">{{ auth()->user()->name }} (Marketing)</div>
                    <div class="text-xs text-gray-400">{{ now()->translatedFormat('d F Y') }}</div>
                </div>
            </div>

            <div class="space-y-3">
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Judul Proyek :</label>
                    <input type="text" name="name" placeholder="Isi Judul Proyek"
                           value="{{ old('name') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 @error('name') border-red-400 @enderror">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Klien :</label>
                    <select name="client_id"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                        <option value="">Pilih Klien</option>
                        @foreach($kliens as $klien)
                            <option value="{{ $klien->id }}" {{ old('client_id') == $klien->id ? 'selected' : '' }}>
                                {{ $klien->user->name }} {{ $klien->company_name ? '('.$klien->company_name.')' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('client_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Lokasi Proyek :</label>
                    <input type="text" name="location" placeholder="Isi Lokasi Proyek"
                           value="{{ old('location') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>

                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Deskripsi Proyek :</label>
                    <textarea name="description" rows="4" placeholder="Isi Deskripsi Proyek"
                              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 resize-none @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
                    @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Estimasi Anggaran :</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-500 font-medium">Rp</span>
                        <input type="text" id="budget_display" placeholder="0"
                               value="{{ old('budget_estimate') ? number_format(old('budget_estimate'), 0, ',', '.') : '' }}"
                               class="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 @error('budget_estimate') border-red-400 @enderror">
                        <input type="hidden" name="budget_estimate" id="budget_estimate_raw"
                               value="{{ old('budget_estimate') }}">
                    </div>
                    @error('budget_estimate')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-3">Informasi Lainnya</h3>
            <textarea name="other_info" rows="5" placeholder="Isi Informasi Pendukung"
                      class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 resize-none">{{ old('other_info') }}</textarea>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-3">Saran atau Masukan</h3>
            <textarea name="notes" rows="3" placeholder="Berikan Komentar (Opsional)"
                      class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 resize-none">{{ old('notes') }}</textarea>
        </div>

    </div>
    </form>

    {{-- KANAN --}}
    <div class="space-y-4">

        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-3">Dokumentasi Proyek</h3>
            <label for="foto"
                   class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 overflow-hidden">
                <div id="preview-area" class="flex flex-col items-center justify-center text-gray-400 w-full h-full">
                    <svg class="w-10 h-10 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm">Upload Gambar</span>
                </div>
                <input type="file" id="foto" name="foto" accept="image/*" class="hidden" form="formPengajuan"
                       onchange="previewImage(event)">
            </label>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-3 text-blue-500">Masukkan Link Google Maps</h3>
            <input type="text" name="maps_link" id="maps_link" form="formPengajuan"
                   placeholder="https://maps.app.goo.gl/..."
                   value="{{ old('maps_link') }}"
                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 mb-3">
            <div id="maps-preview" class="bg-gray-100 rounded-xl h-32 overflow-hidden flex items-center justify-center text-gray-400 text-xs">
                Preview Maps
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-3">Riwayat Pengajuan</h3>
            <div class="flex items-center gap-3">
                <img src="" class="w-10 h-10 rounded-full"
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3b5bdb&color=fff&size=40'">
                <div>
                    <div class="text-sm font-semibold text-gray-700">{{ auth()->user()->name }} Mengajukan Proyek Ini</div>
                    <div class="text-xs text-gray-400">{{ now()->translatedFormat('d F Y') }}</div>
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('marketing.dashboard') }}"
               class="flex-1 py-3 bg-red-500 text-white rounded-xl font-semibold text-center hover:bg-red-600 transition text-sm">
                Batal
            </a>
            <button type="submit" form="formPengajuan"
                    class="flex-1 py-3 bg-green-500 text-white rounded-xl font-semibold hover:bg-green-600 transition text-sm">
                Kirim Form Pengajuan
            </button>
        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('preview-area').innerHTML =
            `<img src="${e.target.result}" class="w-full h-full object-cover">`;
    };
    reader.readAsDataURL(file);
}

const budgetDisplay = document.getElementById('budget_display');
const budgetRaw = document.getElementById('budget_estimate_raw');

budgetDisplay.addEventListener('input', function() {
    let raw = this.value.replace(/\D/g, '');
    budgetRaw.value = raw;
    this.value = raw ? parseInt(raw).toLocaleString('id-ID') : '';
});

document.getElementById('maps_link').addEventListener('input', function() {
    const link = this.value.trim();
    const preview = document.getElementById('maps-preview');
    if (link !== '') {
        preview.innerHTML = `
            <a href="${link}" target="_blank"
               class="flex flex-col items-center justify-center gap-2 text-blue-500 hover:text-blue-700 w-full h-full">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="text-xs font-medium">Klik untuk buka Google Maps</span>
            </a>`;
    } else {
        preview.innerHTML = 'Preview Maps';
    }
});
</script>
@endpush