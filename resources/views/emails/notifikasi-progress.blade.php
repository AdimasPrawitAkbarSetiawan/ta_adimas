<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; }
        .header { background: #8b5cf6; padding: 30px; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 24px; }
        .header p { color: #ede9fe; margin: 5px 0 0; font-size: 13px; }
        .body { padding: 30px; }
        .body h2 { color: #333; font-size: 18px; }
        .info-box { background: #faf5ff; border-left: 4px solid #8b5cf6; padding: 15px; border-radius: 6px; margin: 20px 0; }
        .info-box p { margin: 5px 0; font-size: 14px; color: #444; }
        .info-box strong { color: #222; }
        .progress-bar { background: #e5e7eb; border-radius: 999px; height: 12px; margin: 10px 0; }
        .progress-fill { background: #8b5cf6; height: 12px; border-radius: 999px; }
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
        <h2>Update Progres Proyek 📊</h2>
        <p style="color:#666; font-size:14px;">Tim operasional telah memperbarui progres proyek berikut:</p>

        <div class="info-box">
            <p><strong>Nama Proyek:</strong> {{ $project->name }}</p>
            <p><strong>Judul Update:</strong> {{ $progres->title }}</p>
            <p><strong>Keterangan:</strong> {{ $progres->description }}</p>
            <p><strong>Persentase Progres:</strong> {{ $progres->percentage }}%</p>
            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ $progres->percentage }}%"></div>
            </div>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($progres->tanggal_laporan ?? $progres->created_at)->translatedFormat('d F Y') }}</p>
        </div>

        <p style="color:#666; font-size:14px;">Login ke sistem untuk melihat detail progres dan foto dokumentasi.</p>
    </div>
    <div class="footer">
        <p>Email ini dikirim otomatis oleh sistem SIMP-PRO. Mohon tidak membalas email ini.</p>
        <p>&copy; {{ date('Y') }} PT Sketsa Instrumentasi Persada</p>
    </div>
</div>
</body>
</html>