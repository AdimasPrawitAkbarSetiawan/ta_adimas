<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $formMasuk        = Project::whereIn('status', ['review'])->count();
        $totalDisetujui   = Project::where('status', 'approved')->count();
        $totalPending     = Project::where('status', 'in_progress')->count();
        $totalDitolak     = Project::where('status', 'rejected')->count();
        $proyekBerjalan   = Project::where('status', 'in_progress')->count();
        $proyekSelesai    = Project::where('status', 'completed')->count();

        return view('owner.dashboard', compact(
            'formMasuk', 'totalDisetujui', 'totalPending',
            'totalDitolak', 'proyekBerjalan', 'proyekSelesai'
        ));
    }
}