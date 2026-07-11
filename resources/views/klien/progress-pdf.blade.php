<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Progress {{ $project->project_code }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h1 { font-size: 18px; margin-bottom: 0; }
        .subtitle { color: #666; margin-top: 2px; margin-bottom: 15px; }
        table.info { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        table.info td { padding: 4px 6px; vertical-align: top; }
        table.info td.label { width: 140px; font-weight: bold; }
        .section-title { font-size: 15px; margin-top: 10px; margin-bottom: 8px; border-bottom: 2px solid #2563eb; padding-bottom: 4px; }
        .rincian { background: #f9fafb; padding: 10px; border-radius: 6px; margin-bottom: 20px; }
        .progress-item { margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #ddd; }
        .progress-title { font-size: 14px; font-weight: bold; margin-bottom: 3px; }
        .progress-meta { color: #666; font-size: 11px; margin-bottom: 6px; }
        .progress-desc { margin-bottom: 8px; }
        .photo-grid { width: 100%; }
        .photo-grid td { padding: 4px; text-align: center; }
        .photo-grid img { width: 260px; max-height: 400px; object-fit: cover; border: 1px solid #ccc; border-radius: 4px; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 4px; background: #e8f0fe; color: #1a56db; font-size: 11px; }
    </style>
</head>
<body>
    <h1>Laporan Progress Proyek</h1>
    <div class="subtitle">{{ $project->name }} ({{ $project->project_code }})</div>

    <table class="info">
        <tr>
            <td class="label">Lokasi</td>
            <td>{{ $project->location ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Status Proyek</td>
            <td>{{ ucfirst($project->status) }}</td>
        </tr>
        @if($project->marketing)
        <tr>
            <td class="label">Marketing</td>
            <td>{{ $project->marketing->name }}</td>
        </tr>
        @endif
        <tr>
            <td class="label">Tanggal Cetak</td>
            <td>{{ now()->format('d F Y, H:i') }}</td>
        </tr>
    </table>

    @if($project->detail && $project->detail->scope_of_work)
    <div class="section-title">Rincian Proyek</div>
    <div class="rincian">{{ $project->detail->scope_of_work }}</div>
    @endif

    <div class="section-title">Riwayat Progress</div>

    @forelse ($project->progress->sortBy('tanggal_laporan') as $item)
        <div class="progress-item">
            <div class="progress-title">{{ $item->title }}</div>
            <div class="progress-meta">
                Tanggal Laporan: {{ \Carbon\Carbon::parse($item->tanggal_laporan)->format('d F Y') }}
                &nbsp;|&nbsp;
                <span class="badge">{{ $item->percentage }}%</span>
            </div>
            <div class="progress-desc">{{ $item->description }}</div>

            @if($item->photos->count() > 0)
                <table class="photo-grid">
                    <tr>
                        @foreach ($item->photos as $photo)
                            <td>
                                @if($photo->base64)
                                    <img src="{{ $photo->base64 }}">
                                @endif
                            </td>
                            @if(($loop->iteration % 3) == 0 && !$loop->last)
                                </tr><tr>
                            @endif
                        @endforeach
                    </tr>
                </table>
            @endif
        </div>
    @empty
        <p>Belum ada progress yang dilaporkan untuk proyek ini.</p>
    @endforelse
</body>
</html>