@extends('operasional.layouts.app')

@section('title', 'Input Kebutuhan Proyek')
@section('judul-halaman', 'Input Kebutuhan Proyek')

@section('konten')

<form method="POST" action="{{ route('operasional.input-kebutuhan.store', $project->id) }}">
@csrf

{{-- Info Proyek --}}
<div class="bg-white rounded-2xl shadow-sm p-5 mb-4">
    <div class="flex items-start gap-3">
        <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <div class="flex-1">
            <p class="text-sm font-semibold text-gray-700">Nama Proyek : {{ $project->name }}</p>
            <p class="text-xs text-gray-500 mt-1">Lokasi Proyek : {{ $project->location ?? '-' }}</p>
            @if($project->maps_link)
    <a href="{{ $project->maps_link }}" target="_blank"
       class="flex items-center gap-1 text-xs text-blue-500 hover:text-blue-700 mt-1">
        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        Lihat di Google Maps
    </a>
    @endif
        </div>
        <span class="bg-green-500 text-white text-xs font-semibold px-3 py-1 rounded-full">Disetujui</span>
    </div>
</div>

{{-- Tabel Material --}}
<div class="bg-white rounded-2xl shadow-sm p-5 mb-4">
    <h3 class="font-bold text-gray-800 mb-4">Masukkan Kebutuhan Material</h3>
    <table class="w-full text-sm" id="tabelMaterial">
        <thead>
            <tr class="text-gray-500 text-xs border-b border-gray-100">
                <th class="pb-2 text-left w-1/3">Material</th>
                <th class="pb-2 text-left w-1/3">Kebutuhan</th>
                <th class="pb-2 text-left w-1/3">Satuan</th>
                <th class="pb-2 w-16"></th>
            </tr>
        </thead>
        <tbody id="barisMaterial">
            @if($project->detail && $project->detail->material)
                @foreach(json_decode($project->detail->material, true) as $m)
                <tr class="baris-material border-b border-gray-50">
                    <td class="py-2 pr-2">
                        <input type="text" name="material_nama[]" value="{{ $m['nama'] }}"
                               placeholder="Nama material"
                               class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </td>
                    <td class="py-2 pr-2">
                        <input type="text" name="material_kebutuhan[]" value="{{ $m['kebutuhan'] }}"
                               placeholder="Jumlah"
                               class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </td>
                    <td class="py-2 pr-2">
                        <input type="text" name="material_satuan[]" value="{{ $m['satuan'] }}"
                               placeholder="Satuan"
                               class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </td>
                    <td class="py-2 text-center">
                        <button type="button" onclick="hapusBaris(this)"
                                class="text-red-400 hover:text-red-600">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </td>
                </tr>
                @endforeach
            @else
            <tr class="baris-material border-b border-gray-50">
                <td class="py-2 pr-2">
                    <input type="text" name="material_nama[]" placeholder="Nama material"
                           class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                </td>
                <td class="py-2 pr-2">
                    <input type="text" name="material_kebutuhan[]" placeholder="Jumlah"
                           class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                </td>
                <td class="py-2 pr-2">
                    <input type="text" name="material_satuan[]" placeholder="Satuan"
                           class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                </td>
                <td class="py-2 text-center">
                    <button type="button" onclick="hapusBaris(this)" class="text-red-400 hover:text-red-600">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </td>
            </tr>
            @endif
        </tbody>
    </table>
    <button type="button" onclick="tambahMaterial()"
            class="mt-3 text-xs text-green-600 font-semibold flex items-center gap-1 hover:text-green-700">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Material
    </button>
</div>

{{-- Tabel Alat Kerja --}}
<div class="bg-white rounded-2xl shadow-sm p-5 mb-4">
    <h3 class="font-bold text-gray-800 mb-4">Masukkan Kebutuhan Alat Kerja</h3>
    <table class="w-full text-sm" id="tabelAlat">
        <thead>
            <tr class="text-gray-500 text-xs border-b border-gray-100">
                <th class="pb-2 text-left w-1/3">Alat Kerja</th>
                <th class="pb-2 text-left w-1/3">Jumlah/Ukuran</th>
                <th class="pb-2 text-left w-1/3">Satuan</th>
                <th class="pb-2 w-16"></th>
            </tr>
        </thead>
        <tbody id="barisAlat">
            @if($project->detail && $project->detail->alat_kerja)
                @foreach(json_decode($project->detail->alat_kerja, true) as $a)
                <tr class="baris-alat border-b border-gray-50">
                    <td class="py-2 pr-2">
                        <input type="text" name="alat_nama[]" value="{{ $a['nama'] }}"
                               placeholder="Nama alat"
                               class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </td>
                    <td class="py-2 pr-2">
                        <input type="text" name="alat_jumlah[]" value="{{ $a['jumlah'] }}"
                               placeholder="Jumlah"
                               class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </td>
                    <td class="py-2 pr-2">
                        <input type="text" name="alat_satuan[]" value="{{ $a['satuan'] }}"
                               placeholder="Satuan"
                               class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </td>
                    <td class="py-2 text-center">
                        <button type="button" onclick="hapusBaris(this)" class="text-red-400 hover:text-red-600">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </td>
                </tr>
                @endforeach
            @else
            <tr class="baris-alat border-b border-gray-50">
                <td class="py-2 pr-2">
                    <input type="text" name="alat_nama[]" placeholder="Nama alat"
                           class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                </td>
                <td class="py-2 pr-2">
                    <input type="text" name="alat_jumlah[]" placeholder="Jumlah"
                           class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                </td>
                <td class="py-2 pr-2">
                    <input type="text" name="alat_satuan[]" placeholder="Satuan"
                           class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                </td>
                <td class="py-2 text-center">
                    <button type="button" onclick="hapusBaris(this)" class="text-red-400 hover:text-red-600">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </td>
            </tr>
            @endif
        </tbody>
    </table>
    <button type="button" onclick="tambahAlat()"
            class="mt-3 text-xs text-green-600 font-semibold flex items-center gap-1 hover:text-green-700">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Alat
    </button>
</div>

{{-- Lingkup Pekerjaan & Tanggal --}}
<div class="bg-white rounded-2xl shadow-sm p-5 mb-4">
    <h3 class="font-bold text-gray-800 mb-4">Lingkup Pekerjaan & Jadwal</h3>

    <div class="mb-4">
        <label class="text-xs text-gray-500 mb-1 block">Lingkup Pekerjaan :</label>
        <textarea name="lingkup_pekerjaan" rows="4" placeholder="Masukkan rincian lingkup pekerjaan..."
                  class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 resize-none @error('lingkup_pekerjaan') border-red-400 @enderror">{{ old('lingkup_pekerjaan', $project->detail->scope_of_work ?? '') }}</textarea>
        @error('lingkup_pekerjaan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="text-xs text-gray-500 mb-1 block">Tanggal Mulai :</label>
            <input type="date" name="tanggal_mulai"
                   value="{{ old('tanggal_mulai', $project->detail->start_date ?? '') }}"
                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 @error('tanggal_mulai') border-red-400 @enderror">
            @error('tanggal_mulai')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="text-xs text-gray-500 mb-1 block">Tanggal Selesai :</label>
            <input type="date" name="tanggal_selesai"
                   value="{{ old('tanggal_selesai', $project->detail->end_date ?? '') }}"
                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 @error('tanggal_selesai') border-red-400 @enderror">
            @error('tanggal_selesai')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    <div>
        <label class="text-xs text-gray-500 mb-1 block">Catatan Tambahan :</label>
        <textarea name="catatan" rows="3" placeholder="Catatan tambahan (opsional)..."
                  class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 resize-none">{{ old('catatan', $project->detail->notes ?? '') }}</textarea>
    </div>
</div>

{{-- Tombol --}}
<div class="flex justify-end gap-3">
    <a href="{{ route('operasional.proyek-disetujui.index') }}"
       class="px-6 py-2 bg-red-500 text-white rounded-lg text-sm font-semibold hover:bg-red-600">
        Batal
    </a>
    <button type="submit"
            class="px-6 py-2 bg-green-500 text-white rounded-lg text-sm font-semibold hover:bg-green-600">
        Simpan & Mulai Proyek
    </button>
</div>

</form>

@endsection

@push('scripts')
<script>
function tambahMaterial() {
    const tbody = document.getElementById('barisMaterial');
    const baris = document.createElement('tr');
    baris.className = 'baris-material border-b border-gray-50';
    baris.innerHTML = `
        <td class="py-2 pr-2">
            <input type="text" name="material_nama[]" placeholder="Nama material"
                   class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
        </td>
        <td class="py-2 pr-2">
            <input type="text" name="material_kebutuhan[]" placeholder="Jumlah"
                   class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
        </td>
        <td class="py-2 pr-2">
            <input type="text" name="material_satuan[]" placeholder="Satuan"
                   class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
        </td>
        <td class="py-2 text-center">
            <button type="button" onclick="hapusBaris(this)" class="text-red-400 hover:text-red-600">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </td>`;
    tbody.appendChild(baris);
}

function tambahAlat() {
    const tbody = document.getElementById('barisAlat');
    const baris = document.createElement('tr');
    baris.className = 'baris-alat border-b border-gray-50';
    baris.innerHTML = `
        <td class="py-2 pr-2">
            <input type="text" name="alat_nama[]" placeholder="Nama alat"
                   class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
        </td>
        <td class="py-2 pr-2">
            <input type="text" name="alat_jumlah[]" placeholder="Jumlah"
                   class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
        </td>
        <td class="py-2 pr-2">
            <input type="text" name="alat_satuan[]" placeholder="Satuan"
                   class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
        </td>
        <td class="py-2 text-center">
            <button type="button" onclick="hapusBaris(this)" class="text-red-400 hover:text-red-600">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </td>`;
    tbody.appendChild(baris);
}

function hapusBaris(btn) {
    const baris = btn.closest('tr');
    baris.remove();
}
</script>
@endpush