<?php

namespace App\Http\Controllers\Klien;

use App\Http\Controllers\Controller;
use App\Models\Klien;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        $klien = Klien::where('user_id', auth()->id())->first();

        if (!$klien) {
            return view('klien.dashboard', ['proyek' => collect()]);
        }

        $proyek = Project::with(['progress.photos', 'detail', 'latestProgress'])
                         ->where('client_id', $klien->id)
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('klien.dashboard', compact('proyek'));
    }

    public function show(Project $project)
    {
        $klien = Klien::where('user_id', auth()->id())->first();

        if (!$klien || $project->client_id !== $klien->id) {
            abort(403, 'Anda tidak memiliki akses ke proyek ini.');
        }

        $project->load(['detail', 'progress.photos', 'marketing']);

        return view('klien.progres-proyek', compact('project'));
    }

    public function cetakProgress(Project $project)
    {
        $klien = Klien::where('user_id', auth()->id())->first();

        if (!$klien || $project->client_id !== $klien->id) {
            abort(403, 'Anda tidak memiliki akses ke proyek ini.');
        }

        $project->load(['detail', 'progress.photos', 'marketing']);

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
}