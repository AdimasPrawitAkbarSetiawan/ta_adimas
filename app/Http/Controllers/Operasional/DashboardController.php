<?php

namespace App\Http\Controllers\Operasional;

use App\Http\Controllers\Controller;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $proyekDisetujui = Project::where('status', 'approved')->count();
        $proyekBerjalan  = Project::where('status', 'in_progress')->count();

        return view('operasional.dashboard', compact('proyekDisetujui', 'proyekBerjalan'));
    }
}