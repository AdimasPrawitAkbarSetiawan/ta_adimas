<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Projectnote;
use App\Models\User;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;

class KebutuhanController extends Controller
{
    public function index()
    {
        $projects = Project::with(['klien.user', 'marketing'])
            ->where('status', 'pending_detail')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('owner.kebutuhan.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $project->load(['klien.user', 'marketing', 'detail']);
        return view('owner.kebutuhan.show', compact('project'));
    }

    public function approve(Request $request, Project $project)
    {
        $project->update(['status' => 'in_progress']);

        if ($project->detail) {
            NotificationHelper::send(
                $project->detail->operational_id,
                'Kebutuhan Proyek Disetujui ✅',
                "Kebutuhan proyek \"{$project->name}\" telah disetujui owner. Proyek siap berjalan!",
                'approved',
                route('operasional.proyek-berjalan.index')
            );
        }

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            NotificationHelper::send(
                $admin->id,
                'Proyek Mulai Berjalan',
                "Owner menyetujui kebutuhan proyek \"{$project->name}\". Proyek sekarang berjalan.",
                'in_progress',
                route('admin.monitoring.index')
            );
        }

        return redirect()->route('owner.monitoring.index')
            ->with('success', 'Kebutuhan proyek disetujui. Proyek sekarang berjalan!');
    }

    public function revisi(Request $request, Project $project)
    {
        $request->validate(['note' => 'required'], [
            'note.required' => 'Catatan revisi wajib diisi.',
        ]);

        $project->update(['status' => 'revision_detail']);

        // Simpan catatan revisi agar bisa ditampilkan ke Operasional
        Projectnote::create([
            'project_id' => $project->id,
            'owner_id'   => auth()->id(),
            'note'       => $request->note,
            'type'       => 'revision_kebutuhan',
        ]);

        if ($project->detail) {
            NotificationHelper::send(
                $project->detail->operational_id,
                'Kebutuhan Proyek Perlu Direvisi ⚠️',
                "Kebutuhan proyek \"{$project->name}\" perlu direvisi. Catatan: {$request->note}",
                'revision',
                route('operasional.kebutuhan-direvisi.index')
            );
        }

        return redirect()->route('owner.monitoring.index')
            ->with('success', 'Kebutuhan proyek dikembalikan untuk direvisi.');
    }
}