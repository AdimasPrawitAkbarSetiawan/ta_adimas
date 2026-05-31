@extends('owner.layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Keputusan</h1>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Proyek</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Proyek</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Klien</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($projects as $project)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $project->project_code }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $project->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $project->klien->name ?? '-' }}</td>
                    <td class="px-6 py-4">
                        @php
                            $badge = match($project->status) {
                                'approved' => 'bg-green-100 text-green-700',
                                'rejected' => 'bg-red-100 text-red-700',
                                'revision' => 'bg-yellow-100 text-yellow-700',
                                default    => 'bg-gray-100 text-gray-600',
                            };
                            $label = match($project->status) {
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                                'revision' => 'Revisi',
                                default    => $project->status,
                            };
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                            {{ $label }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $project->updated_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('owner.riwayat-keputusan.show', $project) }}"
                           class="text-blue-600 hover:underline text-sm font-medium">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                        Belum ada riwayat keputusan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection