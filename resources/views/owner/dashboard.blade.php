@extends('owner.layouts.app')

@section('title', 'Dashboard Owner')
@section('page-title', 'Dashboard Owner')

@section('content')

<div class="grid grid-cols-4 gap-4 mb-4">

    <div class="bg-white rounded-2xl p-5 flex items-center justify-between shadow-sm">
        <div>
            <p class="text-xs text-gray-400 mb-1">Form Masuk</p>
            <p class="text-3xl font-bold text-gray-800">{{ $formMasuk }}</p>
            <a href="{{ route('owner.form-pengajuan.index') }}" class="text-xs text-blue-500 font-medium mt-2 inline-block hover:underline">{{ $formMasuk }} Form Pengajuan Masuk</a>
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
            <a href="{{ route('owner.riwayat-keputusan.index') }}" class="text-xs text-green-500 font-medium mt-2 inline-block hover:underline">{{ $totalDisetujui }} Form Selesai</a>
        </div>
        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 flex items-center justify-between shadow-sm">
        <div>
            <p class="text-xs text-gray-400 mb-1">Total Pending</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalPending }}</p>
            <span class="text-xs text-yellow-500 font-medium mt-2 inline-block">{{ $totalPending }} Form Dalam Proses</span>
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

<div class="grid grid-cols-4 gap-4">

    <div class="bg-white rounded-2xl p-5 flex items-center justify-between shadow-sm">
        <div>
            <p class="text-xs text-gray-400 mb-1">Total Proyek Berjalan</p>
            <p class="text-3xl font-bold text-gray-800">{{ $proyekBerjalan }}</p>
            <span class="text-xs text-blue-500 font-medium mt-2 inline-block">{{ $proyekBerjalan }} Proyek Dikerjakan</span>
        </div>
        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
            </svg>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 flex items-center justify-between shadow-sm">
        <div>
            <p class="text-xs text-gray-400 mb-1">Total Proyek Selesai</p>
            <p class="text-3xl font-bold text-gray-800">{{ $proyekSelesai }}</p>
            <span class="text-xs text-green-500 font-medium mt-2 inline-block">{{ $proyekSelesai }} Proyek Selesai</span>
        </div>
        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
    </div>

</div>

@endsection