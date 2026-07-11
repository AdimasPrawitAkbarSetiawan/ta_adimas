<?php

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Project;

public function cetakProgress(Project $project)
{
    // pastikan cuma klien pemilik project yang bisa cetak
    if ($project->client_id !== auth()->id()) {
        abort(403, 'Anda tidak memiliki akses ke project ini.');
    }

    $project->load(['progress.photos', 'progress.operational']);

    // ubah foto ke base64 supaya pasti muncul di PDF
    foreach ($project->progress as $progress) {
        foreach ($progress->photos as $photo) {
            $path = public_path('storage/' . $photo->file_path);
            if (file_exists($path)) {
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $photo->base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            } else {
                $photo->base64 = null;
            }
        }
    }

    $pdf = Pdf::loadView('klien.progress-pdf', compact('project'))
        ->setPaper('a4', 'portrait');

    return $pdf->stream('Progress-' . $project->project_code . '.pdf');
}