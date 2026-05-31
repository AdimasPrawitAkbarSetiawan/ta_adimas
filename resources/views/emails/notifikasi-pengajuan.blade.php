<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; }
        .header { background: #3b5bdb; padding: 30px; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 24px; }
        .header p { color: #c5d0fa; margin: 5px 0 0; font-size: 13px; }
        .body { padding: 30px; }
        .body h2 { color: #333; font-size: 18px; }
        .info-box { background: #f8f9ff; border-left: 4px solid #3b5bdb; padding: 15px; border-radius: 6px; margin: 20px 0; }
        .info-box p { margin: 5px 0; font-size: 14px; color: #444; }
        .info-box strong { color: #222; }
        .btn { display: inline-block; background: #3b5bdb; color: white; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: bold; margin-top: 20px; }
        .footer { background: #f8f9ff; padding: 20px; text-align: center; font-size: 12px; color: #888; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>SIMP-PRO</h1>
        <p>Sistem Manajemen Pengajuan Proyek</p>
    </div>
    <div class="body">
        <h2>Ada Pengajuan Proyek Baru!</h2>
        <p style="color:#666; font-size:14px;">Tim Marketing telah mengajukan proyek baru yang memerlukan persetujuan Anda.</p>

        <div class="info-box">
            <p><strong>Nama Proyek:</strong> {{ $project->name }}</p>
            <p><strong>Klien:</strong> {{ $project->klien->user->name ?? '-' }}</p>
            <p><strong>Lokasi:</strong> {{ $project->location ?? '-' }}</p>
            <p><strong>Estimasi Anggaran:</strong> Rp {{ number_format($project->budget_estimate, 0, ',', '.') }}</p>
            <p><strong>Diajukan oleh:</strong> {{ $project->marketing->name ?? '-' }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($project->created_at)->translatedFormat('d F Y') }}</p>
        </div>

        <p style="color:#666; font-size:14px;">Silakan login ke sistem untuk meninjau dan memberikan keputusan.</p>
    </div>
    <div class="footer">
        <p>Email ini dikirim otomatis oleh sistem SIMP-PRO. Mohon tidak membalas email ini.</p>
        <p>&copy; {{ date('Y') }} PT Sketsa Instrumentasi Persada</p>
    </div>
</div>
</body>
</html>