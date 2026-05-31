<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $formDiajukan   = Project::where('marketing_id', $userId)->count();
        $totalDisetujui = Project::where('marketing_id', $userId)->where('status', 'approved')->count();
        $totalRevisi    = Project::where('marketing_id', $userId)->where('status', 'revision')->count();
        $totalDitolak   = Project::where('marketing_id', $userId)->where('status', 'rejected')->count();

        return view('marketing.dashboard', compact(
            'formDiajukan', 'totalDisetujui', 'totalRevisi', 'totalDitolak'
        ));
    }
}