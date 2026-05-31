<?php

namespace App\Http\Controllers\Owner;

use App\Mail\NotifikasiPersetujuan;
use App\Mail\NotifikasiRevisi;
use App\Helpers\NotificationHelper;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Projectnote;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewFormController extends Controller
{
    public function index()
    {
        $projects = Project::with(['klien.user', 'marketing'])
            ->where('status', 'review')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('owner.form-pengajuan.index', compact('projects'));
    }

    public function formRevisi()
    {
        $projects = Project::with(['klien.user', 'marketing'])
            ->where('status', 'revision')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('owner.form-revisi.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $project->load(['klien.user', 'marketing', 'notes.owner', 'progress.photos']);
        return view('owner.form-pengajuan.show', compact('project'));
    }

    public function approve(Request $request, Project $project)
    {
        $project->update([
            'status'      => 'approved',
            'approved_at' => now(),
        ]);


        Projectnote::create([
            'project_id' => $project->id,
            'owner_id'   => auth()->id(),
            'note'       => $request->note ?? 'Proyek disetujui.',
            'type'       => 'approval',
        ]);

        // Notif ke marketing
        NotificationHelper::send(
            $project->marketing_id,
            'Proyek Disetujui ✅',
            "Proyek \"{$project->name}\" telah disetujui oleh owner.",
            'approved'
        );

        // Notif ke semua admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            NotificationHelper::send(
                $admin->id,
                'Proyek Disetujui',
                "Owner telah menyetujui proyek \"{$project->name}\".",
                'approved'
            );
        }

        return redirect()->route('owner.form-pengajuan.index')
            ->with('success', 'Proyek berhasil disetujui.');
    }

    public function reject(Request $request, Project $project)
    {
        $request->validate(['note' => 'required'], [
            'note.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $project->update(['status' => 'rejected']);

        Projectnote::create([
            'project_id' => $project->id,
            'owner_id'   => auth()->id(),
            'note'       => $request->note,
            'type'       => 'rejection',
        ]);

        // Notif ke marketing
        NotificationHelper::send(
            $project->marketing_id,
            'Proyek Ditolak ❌',
            "Proyek \"{$project->name}\" ditolak. Alasan: {$request->note}",
            'rejected'
        );

        // Notif ke semua admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            NotificationHelper::send(
                $admin->id,
                'Proyek Ditolak',
                "Owner telah menolak proyek \"{$project->name}\".",
                'rejected'
            );
        }

        return redirect()->route('owner.form-pengajuan.index')
            ->with('success', 'Proyek berhasil ditolak.');
    }

    public function revisi(Request $request, Project $project)
    {
        $request->validate(['note' => 'required'], [
            'note.required' => 'Catatan revisi wajib diisi.',
        ]);

        $project->update(['status' => 'revision']);

        Projectnote::create([
            'project_id' => $project->id,
            'owner_id'   => auth()->id(),
            'note'       => $request->note,
            'type'       => 'revision',
        ]);

        // Notif ke marketing
        NotificationHelper::send(
            $project->marketing_id,
            'Proyek Perlu Revisi ⚠️',
            "Proyek \"{$project->name}\" dikembalikan untuk revisi. Catatan: {$request->note}",
            'revision'
        );

        // Notif ke semua admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            NotificationHelper::send(
                $admin->id,
                'Proyek Perlu Revisi',
                "Owner meminta revisi untuk proyek \"{$project->name}\".",
                'revision'
            );
        }

        return redirect()->route('owner.form-pengajuan.index')
            ->with('success', 'Proyek dikembalikan untuk revisi.');
    }
}