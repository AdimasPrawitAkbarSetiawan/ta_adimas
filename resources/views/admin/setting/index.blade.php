@extends('admin.layout.app')

@section('title', 'Setting')
@section('page-title', 'Setting Admin')

@section('content')

<div class="space-y-4">

    {{-- Ubah Logo --}}
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">Ubah Logo Sistem</h3>

        <form method="POST" action="{{ route('admin.settings.logo') }}" enctype="multipart/form-data">
            @csrf

            <label for="logo-upload"
                   class="block bg-gray-100 rounded-xl p-6 text-center cursor-pointer hover:bg-gray-200 transition">
                <div class="flex justify-center mb-3">
                    <div class="bg-white rounded-2xl px-8 py-4 shadow-sm">
                        <img src="{{ asset('images/logo_simppro.png') }}" alt="Logo" class="h-14 mx-auto"
                             onerror="this.src='https://via.placeholder.com/200x56?text=SIMP-PRO'">
                    </div>
                </div>
                <p class="text-sm text-gray-500">Drop gambar baru, atau klik untuk mengunggah logo baru (PNG/JPG)</p>
                <input type="file" id="logo-upload" name="logo" accept="image/png,image/jpeg" class="hidden"
                       onchange="this.form.submit()">
            </label>
        </form>
    </div>

    {{-- Backup --}}
    <div class="grid grid-cols-2 gap-4">

        {{-- Backup Database --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-4">Backup Database</h3>
            <form method="POST" action="{{ route('admin.settings.backup') }}">
                @csrf
                <input type="hidden" name="type" value="database">
                <div class="bg-gray-100 rounded-xl h-32 flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                    </svg>
                </div>
                <button type="submit"
                        class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700">
                    Download Backup Database
                </button>
            </form>
        </div>

        {{-- Backup Source Code --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-4">Backup Source Code</h3>
            <form method="POST" action="{{ route('admin.settings.backup-source') }}">
                @csrf
                <div class="bg-gray-100 rounded-xl h-32 flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                </div>
                <button type="submit"
                        class="w-full py-2 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700">
                    Download Backup Source Code
                </button>
            </form>
        </div>

    </div>
</div>

@endsection