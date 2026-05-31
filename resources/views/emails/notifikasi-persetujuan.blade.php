<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; }
        .header { background: #22c55e; padding: 30px; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 24px; }
        .header p { color: #dcfce7; margin: 5px 0 0; font-size: 13px; }
        .body { padding: 30px; }
        .body h2 { color: #333; font-size: 18px; }
        .info-box { background: #f0fdf4; border-left: 4px solid #22c55e; padding: 15px; border-radius: 6px; margin: 20px 0; }
        .info-box p { margin: 5px 0; font-size: 14px; color: #444; }
        .info-box strong { color: #222; }
        .badge { display: inline-block; background: #22c55e; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
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
        <h2>Selamat! Proyek Anda Disetujui ✅</h2>
        <p style="color:#666; font-size:14px;">Owner telah menyetujui pengajuan proyek berikut:</p>

        <div class="info-box">
            <p><strong>Nama Proyek:</strong> {{ $project->name }}</p>
            <p><strong>Klien:</strong> {{ $project->klien->user->name ?? '-' }}</p>
            <p><strong>Lokasi:</strong> {{ $project->location ?? '-' }}</p>
            <p><strong>Estimasi Anggaran:</strong> Rp {{ number_format($project->budget_estimate, 0, ',', '.') }}</p>
            <p><strong>Status:</strong> <span class="badge">Disetujui</span></p>
            <p><strong>Tanggal Persetujuan:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        </div>

        <p style="color:#666; font-size:14px;">Tim operasional akan segera menindaklanjuti proyek ini.</p>
    </div>
    <div class="footer">
        <p>Email ini dikirim otomatis oleh sistem SIMP-PRO. Mohon tidak membalas email ini.</p>
        <p>&copy; {{ date('Y') }} PT Sketsa Instrumentasi Persada</p>
    </div>
</div>
</body>
</html>