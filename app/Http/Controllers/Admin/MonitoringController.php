<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;

class MonitoringController extends Controller
{
    public function index()
    {
        $projects = Project::with(['klien.user', 'marketing', 'latestProgress'])
                           ->orderBy('created_at', 'desc')
                           ->get();

        return view('admin.monitoring.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $project->load(['klien.user', 'marketing', 'detail', 'progress.photos', 'notes.owner']);

        return view('admin.monitoring.show', compact('project'));
    }
}