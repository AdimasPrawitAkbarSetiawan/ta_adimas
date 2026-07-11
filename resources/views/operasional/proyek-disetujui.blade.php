@extends('operasional.layouts.app')

@section('title', 'Proyek Disetujui')
@section('judul-halaman', 'Daftar Proyek Disetujui')

@section('konten')

<div class="bg-white rounded-2xl shadow-sm p-6">

    @if(session('sukses'))
        <div class="bg-green-50 border border-green-200 text-green-600 text-sm rounded-lg px-4 py-3 mb-4">
            {{ session('sukses') }}
        </div>
    @endif

    <div class="relative mb-5">
        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </span>
        <input type="text" id="cariProyek" placeholder="Cari Daftar Proyek"
               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
               onkeyup="cariTabel()">
    </div>

    <div class="rounded-xl overflow-hidden border border-gray-100">
        <table class="w-full text-sm" id="tabelProyek">
            <tbody>
                @forelse($daftar as $proyek)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-gray-400 w-8">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <img src="" class="w-8 h-8 rounded-full"
                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($proyek->name) }}&background=3b5bdb&color=fff&size=32'">
                            <span class="font-medium text-gray-700">{{ $proyek->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-500 text-xs">{{ $proyek->location ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="bg-green-500 text-white text-xs font-semibold px-3 py-1 rounded-full">Disetujui</span>
                    </td>
                    <td class="px-4 py-3 text-gray-500 text-xs">{{ \Carbon\Carbon::parse($proyek->created_at)->format('d-m-Y') }}</td>
                    <td class="px-4 py-3">
                        <a href="{{ route('operasional.input-kebutuhan.show', $proyek->id) }}"
                           class="bg-purple-100 text-purple-600 text-xs font-semibold px-3 py-1 rounded-full hover:bg-purple-200 whitespace-nowrap">
                            Input Kebutuhan Proyek
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-8 text-gray-400">Belum ada proyek baru yang disetujui.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection

@push('scripts')
<script>
function cariTabel() {
    const input = document.getElementById('cariProyek').value.toLowerCase();
    const baris = document.querySelectorAll('#tabelProyek tbody tr');
    baris.forEach(b => {
        b.style.display = b.textContent.toLowerCase().includes(input) ? '' : 'none';
    });
}
</script>
@endpush