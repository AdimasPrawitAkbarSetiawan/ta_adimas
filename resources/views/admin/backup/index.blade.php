@extends('admin.layout.app')

@section('title', 'Backup')
@section('page-title', 'Backup Data')

@section('content')

@if(session('error'))
<div class="mb-4 px-4 py-3 bg-red-100 text-red-700 rounded-xl text-sm font-medium">
    ❌ {{ session('error') }}
</div>
@endif

<div class="grid grid-cols-2 gap-6">

    {{-- Backup Database --}}
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-700">Backup Database</h3>
                <p class="text-xs text-gray-400">Download file .sql</p>
            </div>
        </div>
        <p class="text-xs text-gray-500 mb-4 leading-relaxed">
            Backup semua data di database termasuk tabel users, projects, chat, notifikasi, dan lainnya.
        </p>
        <form method="POST" action="{{ route('admin.settings.backup') }}">
            @csrf
            <input type="hidden" name="type" value="database">
            <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700">
                Download Backup Database
            </button>
        </form>
    </div>

    {{-- Backup Source Code --}}
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-700">Backup Source Code</h3>
                <p class="text-xs text-gray-400">Download file .zip</p>
            </div>
        </div>
        <p class="text-xs text-gray-500 mb-4 leading-relaxed">
            Backup seluruh source code aplikasi.
        </p>
        <form method="POST" action="{{ route('admin.settings.backup-source') }}">
            @csrf
            <button type="submit" class="w-full py-2 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700">
                Download Backup Source Code
            </button>
        </form>
    </div>

</div>

@endsection