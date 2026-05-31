<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; }
        .header { background: #f59e0b; padding: 30px; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 24px; }
        .header p { color: #fef3c7; margin: 5px 0 0; font-size: 13px; }
        .body { padding: 30px; }
        .body h2 { color: #333; font-size: 18px; }
        .info-box { background: #fffbeb; border-left: 4px solid #f59e0b; padding: 15px; border-radius: 6px; margin: 20px 0; }
        .info-box p { margin: 5px 0; font-size: 14px; color: #444; }
        .info-box strong { color: #222; }
        .catatan-box { background: #fef3c7; border: 1px solid #f59e0b; padding: 15px; border-radius: 6px; margin: 15px 0; }
        .catatan-box p { margin: 0; font-size: 14px; color: #92400e; }
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
        <h2>Proyek Perlu Direvisi ⚠️</h2>
        <p style="color:#666; font-size:14px;">Owner telah memberikan catatan revisi untuk pengajuan proyek berikut:</p>

        <div class="info-box">
            <p><strong>Nama Proyek:</strong> {{ $project->name }}</p>
            <p><strong>Klien:</strong> {{ $project->klien->user->name ?? '-' }}</p>
            <p><strong>Lokasi:</strong> {{ $project->location ?? '-' }}</p>
            <p><strong>Estimasi Anggaran:</strong> Rp {{ number_format($project->budget_estimate, 0, ',', '.') }}</p>
        </div>

        <p style="color:#666; font-size:14px;"><strong>Catatan dari Owner:</strong></p>
        <div class="catatan-box">
            <p>{{ $catatan }}</p>
        </div>

        <p style="color:#666; font-size:14px;">Silakan login ke sistem untuk melakukan revisi dan kirim kembali pengajuan.</p>
    </div>
    <div class="footer">
        <p>Email ini dikirim otomatis oleh sistem SIMP-PRO. Mohon tidak membalas email ini.</p>
        <p>&copy; {{ date('Y') }} PT Sketsa Instrumentasi Persada</p>
    </div>
</div>
</body>
</html>