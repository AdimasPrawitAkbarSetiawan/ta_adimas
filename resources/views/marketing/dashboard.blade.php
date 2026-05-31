@extends('marketing.layouts.app')

@section('title', 'Dashboard Marketing')
@section('page-title', 'Dashboard Marketing')

@section('content')

<div class="grid grid-cols-4 gap-4">

    <div class="bg-white rounded-2xl p-5 flex items-center justify-between shadow-sm">
        <div>
            <p class="text-xs text-gray-400 mb-1">Form Diajukan</p>
            <p class="text-3xl font-bold text-gray-800">{{ $formDiajukan }}</p>
            <a href="{{ route('marketing.riwayat.index') }}" class="text-xs text-blue-500 font-medium mt-2 inline-block hover:underline">{{ $formDiajukan }} Form Pengajuan Masuk</a>
        </div>
        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 flex items-center justify-between shadow-sm">
        <div>
            <p class="text-xs text-gray-400 mb-1">Total Disetujui</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalDisetujui }}</p>
            <span class="text-xs text-green-500 font-medium mt-2 inline-block">{{ $totalDisetujui }} Form Selesai</span>
        </div>
        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 flex items-center justify-between shadow-sm">
        <div>
            <p class="text-xs text-gray-400 mb-1">Total Revisi</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalRevisi }}</p>
            <a href="{{ route('marketing.form-revisi.index') }}" class="text-xs text-yellow-500 font-medium mt-2 inline-block hover:underline">{{ $totalRevisi }} Form Dalam Proses</a>
        </div>
        <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 flex items-center justify-between shadow-sm">
        <div>
            <p class="text-xs text-gray-400 mb-1">Total Ditolak</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalDitolak }}</p>
            <span class="text-xs text-red-500 font-medium mt-2 inline-block">{{ $totalDitolak }} Form Ditolak</span>
        </div>
        <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </div>

</div>

@endsection