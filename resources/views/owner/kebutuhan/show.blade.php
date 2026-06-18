@extends('owner.layouts.app')

@section('title', 'Review Kebutuhan Proyek')
@section('page-title', 'Review Kebutuhan Proyek')

@section('content')

<div class="grid grid-cols-2 gap-5">

    {{-- KIRI --}}
    <div class="space-y-4">
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-4">Informasi Proyek</h3>
            <div class="space-y-3">
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Nama Proyek</label>
                    <div class="border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 bg-gray-50">{{ $project->name }}</div>
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Lokasi</label>
                    <div class="border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 bg-gray-50">{{ $project->location ?? '-' }}</div>
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Tanggal Mulai</label>
                    <div class="border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 bg-gray-50">{{ $project->detail->start_date ?? '-' }}</div>
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Tanggal Selesai</label>
                    <div class="border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 bg-gray-50">{{ $project->detail->end_date ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-3">Lingkup Pekerjaan</h3>
            <p class="text-sm text-gray-600 leading-relaxed">{{ $project->detail->scope_of_work ?? '-' }}</p>
        </div>

        @if($project->detail->notes)
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-3">Catatan Tambahan</h3>
            <p class="text-sm text-gray-600 leading-relaxed">{{ $project->detail->notes }}</p>
        </div>
        @endif
    </div>

    {{-- KANAN --}}
    <div class="space-y-4">

        {{-- Material --}}
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-3">Kebutuhan Material</h3>
            @if($project->detail && $project->detail->material)
                @php $materials = json_decode($project->detail->material, true); @endphp
                @if(count($materials) > 0)
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-gray-500 text-xs border-b border-gray-100">
                            <th class="pb-2 text-left">Material</th>
                            <th class="pb-2 text-left">Kebutuhan</th>
                            <th class="pb-2 text-left">Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($materials as $m)
                        <tr class="border-b border-gray-50">
                            <td class="py-2 text-gray-700">{{ $m['nama'] }}</td>
                            <td class="py-2 text-gray-700">{{ $m['kebutuhan'] }}</td>
                            <td class="py-2 text-gray-700">{{ $m['satuan'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-sm text-gray-400">Tidak ada material.</p>
                @endif
            @else
            <p class="text-sm text-gray-400">Tidak ada material.</p>
            @endif
        </div>

        {{-- Alat Kerja --}}
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-3">Kebutuhan Alat Kerja</h3>
            @if($project->detail && $project->detail->alat_kerja)
                @php $alats = json_decode($project->detail->alat_kerja, true); @endphp
                @if(count($alats) > 0)
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-gray-500 text-xs border-b border-gray-100">
                            <th class="pb-2 text-left">Alat Kerja</th>
                            <th class="pb-2 text-left">Jumlah</th>
                            <th class="pb-2 text-left">Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alats as $a)
                        <tr class="border-b border-gray-50">
                            <td class="py-2 text-gray-700">{{ $a['nama'] }}</td>
                            <td class="py-2 text-gray-700">{{ $a['jumlah'] }}</td>
                            <td class="py-2 text-gray-700">{{ $a['satuan'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-sm text-gray-400">Tidak ada alat kerja.</p>
                @endif
            @else
            <p class="text-sm text-gray-400">Tidak ada alat kerja.</p>
            @endif
        </div>

        {{-- Catatan Revisi & Tombol --}}
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-3">Catatan (untuk revisi)</h3>
            <textarea id="note" rows="3" placeholder="Isi catatan jika ingin merevisi..."
                      class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 resize-none mb-4"></textarea>

            <div class="flex gap-3">
                <form method="POST" action="{{ route('owner.kebutuhan.revisi', $project->id) }}" class="flex-1">
                    @csrf
                    <input type="hidden" name="note" id="note-revisi">
                    <button type="submit"
                            class="w-full py-2.5 bg-yellow-400 text-white rounded-xl font-semibold hover:bg-yellow-500 transition text-sm"
                            onclick="document.getElementById('note-revisi').value = document.getElementById('note').value">
                        Revisi
                    </button>
                </form>

                <form method="POST" action="{{ route('owner.kebutuhan.approve', $project->id) }}" class="flex-1">
                    @csrf
                    <button type="submit"
                            class="w-full py-2.5 bg-green-500 text-white rounded-xl font-semibold hover:bg-green-600 transition text-sm">
                        Setujui & Mulai Proyek
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection