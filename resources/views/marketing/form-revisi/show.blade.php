@extends('marketing.layouts.app')

@section('title', 'Perbaiki Form Revisi')
@section('page-title', 'Perbaiki Form Pengajuan')

@section('content')

<form method="POST" action="{{ route('marketing.form-revisi.kirim', $project->id) }}" enctype="multipart/form-data" id="formRevisi">
@csrf

<div class="grid grid-cols-2 gap-5">

    {{-- KIRI --}}
    <div class="space-y-4">

        {{-- Catatan revisi dari Owner --}}
        <div class="bg-orange-50 border border-orange-200 rounded-2xl p-4">
            <p class="text-sm font-semibold text-orange-700 mb-2">Catatan Revisi dari Owner</p>
            @forelse($project->notes->where('type', 'revision')->sortByDesc('created_at') as $note)
                <div class="bg-white border border-orange-200 rounded-lg px-3 py-2 text-sm text-orange-700 mb-2">
                    {{ $note->note }}
                </div>
            @empty
                <p class="text-xs text-orange-500 italic">Tidak ada catatan khusus dari Owner.</p>
            @endforelse
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-4">Perbaiki Detail Pengajuan</h3>

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
                    <input type="text" name="name" placeholder="Isi Judul Proyek"
                           value="{{ old('name', $project->name) }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 @error('name') border-red-400 @enderror">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Lokasi Proyek :</label>
                    <input type="text" name="location" placeholder="Isi Lokasi Proyek"
                           value="{{ old('location', $project->location) }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>

                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Deskripsi Proyek :</label>
                    <textarea name="description" rows="4" placeholder="Isi Deskripsi Proyek"
                              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 resize-none @error('description') border-red-400 @enderror">{{ old('description', $project->description) }}</textarea>
                    @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Estimasi Anggaran :</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-500 font-medium">Rp</span>
                        <input type="text" id="budget_display" placeholder="0"
                               value="{{ old('budget_estimate', number_format($project->budget_estimate, 0, ',', '.')) }}"
                               class="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 @error('budget_estimate') border-red-400 @enderror">
                        <input type="hidden" name="budget_estimate" id="budget_estimate_raw"
                               value="{{ old('budget_estimate', $project->budget_estimate) }}">
                    </div>
                    @error('budget_estimate')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-3">Informasi Lainnya</h3>
            <textarea name="other_info" rows="4" placeholder="Isi Informasi Pendukung"
                      class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 resize-none">{{ old('other_info', $project->other_info) }}</textarea>
        </div>

    </div>

    {{-- KANAN --}}
    <div class="space-y-4">

        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-3">Dokumentasi Proyek</h3>
            <p class="text-xs text-gray-400 mb-2">Foto saat ini (kosongkan jika tidak ingin mengganti):</p>
            @if($project->progress->first()?->photos->first())
                <img src="{{ asset('storage/'.$project->progress->first()->photos->first()->file_path) }}"
                     class="w-full h-40 object-cover rounded-xl mb-3">
            @else
                <div class="w-full h-40 bg-gray-100 rounded-xl flex items-center justify-center text-gray-300 mb-3">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif

            <label for="foto"
                   class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 overflow-hidden">
                <div id="preview-area" class="flex flex-col items-center justify-center text-gray-400 w-full h-full">
                    <svg class="w-7 h-7 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-xs">Unggah Foto Baru (opsional)</span>
                </div>
                <input type="file" id="foto" name="foto" accept="image/*" class="hidden" onchange="previewImage(event)">
            </label>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-3 text-blue-500">Link Google Maps</h3>
            <input type="text" name="maps_link"
                   placeholder="https://maps.app.goo.gl/..."
                   value="{{ old('maps_link', $project->maps_link) }}"
                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
        </div>

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

        <div class="flex gap-3">
            <a href="{{ route('marketing.form-revisi.index') }}"
               class="flex-1 py-3 bg-gray-200 text-gray-600 rounded-xl font-semibold text-center hover:bg-gray-300 transition text-sm">
                Batal
            </a>
            <button type="submit"
                    class="flex-1 py-3 bg-green-500 text-white rounded-xl font-semibold hover:bg-green-600 transition text-sm">
                Kirim Perbaikan
            </button>
        </div>

    </div>
</div>

</form>

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
</script>
@endpushcd ta