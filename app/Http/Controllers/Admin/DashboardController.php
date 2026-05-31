<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUser   = User::where('role', '!=', 'admin')->count();
        $totalRole   = 5; // admin, owner, marketing, operasional, klien
        $totalProyek = Project::count();
        $totalForm   = Project::whereIn('status', ['draft', 'review', 'revision'])->count();

        return view('admin.dashboard', compact(
            'totalUser', 'totalRole', 'totalProyek', 'totalForm'
        ));
    }
}