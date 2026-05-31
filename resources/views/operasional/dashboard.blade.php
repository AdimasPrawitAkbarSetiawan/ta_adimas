@extends('operasional.layouts.app')

@section('title', 'Dashboard Operasional')
@section('judul-halaman', 'Dashboard Operasional')

@section('konten')

<div class="grid grid-cols-4 gap-4">

    <div class="bg-white rounded-2xl p-5 flex items-center justify-between shadow-sm">
        <div>
            <p class="text-xs text-gray-400 mb-1">Proyek Disetujui</p>
            <p class="text-3xl font-bold text-gray-800">{{ $proyekDisetujui }}</p>
            <a href="{{ route('operasional.proyek-disetujui.index') }}" class="text-xs text-blue-500 font-medium mt-2 inline-block hover:underline">{{ $proyekDisetujui }} Proyek Masuk</a>
        </div>
        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 flex items-center justify-between shadow-sm">
        <div>
            <p class="text-xs text-gray-400 mb-1">Proyek Berjalan</p>
            <p class="text-3xl font-bold text-gray-800">{{ $proyekBerjalan }}</p>
            <a href="{{ route('operasional.proyek-berjalan.index') }}" class="text-xs text-green-500 font-medium mt-2 inline-block hover:underline">{{ $proyekBerjalan }} Proyek Dikerjakan</a>
        </div>
        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
            </svg>
        </div>
    </div>

</div>

@endsection