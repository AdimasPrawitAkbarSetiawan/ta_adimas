<?php

namespace App\Http\Controllers\Klien;

use App\Http\Controllers\Controller;
use App\Models\Klien;
use App\Models\Project;

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
}