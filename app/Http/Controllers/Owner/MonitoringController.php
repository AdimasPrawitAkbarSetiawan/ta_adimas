<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Project;

class MonitoringController extends Controller
{
    public function index()
    {
        $projects = Project::with(['klien.user', 'marketing', 'latestProgress'])
                           ->whereIn('status', ['approved', 'pending_detail', 'in_progress', 'completed'])
                           ->orderBy('created_at', 'desc')
                           ->get();

        return view('owner.monitoring.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $project->load(['klien.user', 'marketing', 'detail', 'progress.photos']);
        return view('owner.monitoring.show', compact('project'));
    }
}