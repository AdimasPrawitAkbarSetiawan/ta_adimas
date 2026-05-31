<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Project;

class RiwayatKeputusanController extends Controller
{
    public function index()
    {
        $projects = Project::with(['klien', 'notes'])
            ->whereIn('status', ['approved', 'rejected', 'revision'])
            ->latest()
            ->get();

        return view('owner.riwayat-keputusan.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $project->load(['klien', 'marketing', 'notes']);

        return view('owner.riwayat-keputusan.show', compact('project'));
    }
}