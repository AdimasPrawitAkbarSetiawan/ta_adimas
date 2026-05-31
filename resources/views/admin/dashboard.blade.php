@extends('admin.layout.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')

<div class="grid grid-cols-4 gap-4">

    {{-- Total User --}}
    <div class="bg-white rounded-2xl p-5 flex items-center justify-between shadow-sm">
        <div>
            <p class="text-xs text-gray-400 mb-1">Total User</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalUser }}</p>
            <a href="{{ route('admin.user.index') }}" class="text-xs text-blue-500 font-medium mt-2 inline-block hover:underline">Kelola User</a>
        </div>
        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
            </svg>
        </div>
    </div>

    {{-- Total Role --}}
    <div class="bg-white rounded-2xl p-5 flex items-center justify-between shadow-sm">
        <div>
            <p class="text-xs text-gray-400 mb-1">Total Role</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalRole }}</p>
            <span class="text-xs text-purple-500 font-medium mt-2 inline-block">Kelola Role</span>
        </div>
        <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </div>
    </div>

    {{-- Total Proyek --}}
    <div class="bg-white rounded-2xl p-5 flex items-center justify-between shadow-sm">
        <div>
            <p class="text-xs text-gray-400 mb-1">Total Proyek</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalProyek }}</p>
            <a href="{{ route('admin.monitoring.index') }}" class="text-xs text-yellow-500 font-medium mt-2 inline-block hover:underline">Data Proyek</a>
        </div>
        <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>
    </div>

    {{-- Total Form --}}
    <div class="bg-white rounded-2xl p-5 flex items-center justify-between shadow-sm">
        <div>
            <p class="text-xs text-gray-400 mb-1">Total Form</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalForm }}</p>
            <span class="text-xs text-red-500 font-medium mt-2 inline-block">Review Form</span>
        </div>
        <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
    </div>

</div>

@endsection