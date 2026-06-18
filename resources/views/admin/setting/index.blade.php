@extends('admin.layout.app')

@section('title', 'Setting')
@section('page-title', 'Setting Admin')

@section('content')

@if(session('success'))
<div class="mb-4 px-4 py-3 bg-green-100 text-green-700 rounded-xl text-sm font-medium">
    ✅ {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-4 px-4 py-3 bg-red-100 text-red-700 rounded-xl text-sm font-medium">
    ❌ {{ session('error') }}
</div>
@endif

<div class="grid grid-cols-2 gap-6">

    {{-- Ubah Logo --}}
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">🖼️ Ubah Logo Sistem</h3>
        <form method="POST" action="{{ route('admin.settings.logo') }}" enctype="multipart/form-data">
            @csrf
            <div class="bg-gray-50 rounded-xl p-4 flex justify-center mb-4">
                <img src="{{ asset('images/logo_simppro.png') }}" alt="Logo" class="h-16 object-contain"
                     onerror="this.src='https://via.placeholder.com/200x56?text=SIMP-PRO'">
            </div>
            <label class="block text-xs text-gray-500 mb-2">Upload Logo Baru (PNG/JPG, maks 2MB)</label>
            <input type="file" name="logo" accept="image/png,image/jpeg"
                   class="block w-full text-sm text-gray-600 file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 mb-4">
            @error('logo')
                <p class="text-xs text-red-500 mb-2">{{ $message }}</p>
            @enderror
<button type="submit" style="background-color: {{ \App\Models\Setting::get('app_color', '#3b5bdb') }} !important;" class="mt-4 px-6 py-2 text-white rounded-lg text-sm font-semibold hover:opacity-90 transition">
  Simpan Logo
</button>
        </form>
        <label class="text-xs text-red-500 mb-1 block">*Mohon hati-hati saat mengubah pengaturan ini</label>
    </div>

    {{-- Informasi Aplikasi --}}
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">⚙️ Informasi Aplikasi</h3>
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf
            <div class="space-y-3">
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Nama Aplikasi</label>
                    <input type="text" name="app_name" value="{{ $settings['app_name'] ?? 'SIMP-PRO' }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Warna Tema</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="app_color" value="{{ $settings['app_color'] ?? '#3b5bdb' }}"
                               class="w-10 h-10 rounded-lg border border-gray-200 cursor-pointer">
                        <input type="text" id="color-text" value="{{ $settings['app_color'] ?? '#3b5bdb' }}"
                               class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                               oninput="document.querySelector('[name=app_color]').value=this.value">
                    </div>
                </div>
            </div>
<button type="submit" style="background-color: {{ \App\Models\Setting::get('app_color', '#3b5bdb') }} !important;" class="mt-4 px-6 py-2 text-white rounded-lg text-sm font-semibold hover:opacity-90 transition">
  Simpan 
</button>
            <label class="text-xs text-red-500 mb-1 block">*Mohon hati-hati saat mengubah pengaturan ini</label>
        </form>
    </div>

    {{-- Informasi Perusahaan --}}
    <div class="bg-white rounded-2xl shadow-sm p-6 col-span-2">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">🏢 Informasi Perusahaan</h3>
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf
            {{-- hidden fields untuk app_name dan app_color supaya tidak hilang --}}
            <input type="hidden" name="app_name" value="{{ $settings['app_name'] ?? 'SIMP-PRO' }}">
            <input type="hidden" name="app_color" value="{{ $settings['app_color'] ?? '#3b5bdb' }}">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Nama Perusahaan</label>
                    <input type="text" name="company_name" value="{{ $settings['company_name'] ?? '' }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">No Telepon</label>
                    <input type="text" name="company_phone" value="{{ $settings['company_phone'] ?? '' }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Email Perusahaan</label>
                    <input type="email" name="company_email" value="{{ $settings['company_email'] ?? '' }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Alamat</label>
                    <input type="text" name="company_address" value="{{ $settings['company_address'] ?? '' }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>
            </div>

<button type="submit" style="background-color: {{ \App\Models\Setting::get('app_color', '#3b5bdb') }} !important;" class="mt-4 px-6 py-2 text-white rounded-lg text-sm font-semibold hover:opacity-90 transition">
  Simpan Informasi Perusahaan
</button>


        </form>
        <label class="text-xs text-red-500 mb-1 block">*Mohon hati-hati saat mengubah pengaturan ini</label>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Sync color picker dengan text input
document.querySelector('[name=app_color]').addEventListener('input', function() {
    document.getElementById('color-text').value = this.value;
});
</script>
@endpush