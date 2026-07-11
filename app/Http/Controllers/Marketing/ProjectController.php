<?php

namespace App\Http\Controllers\Marketing;

use App\Helpers\NotificationHelper;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Klien;
use App\Models\Projectprogress;
use App\Models\Projectphoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function create()
    {
        $kliens = Klien::with('user')->get();
        return view('marketing.form.pengajuan', compact('kliens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'client_id'       => 'required|exists:klien,id',
            'description'     => 'required',
            'budget_estimate' => 'required|numeric',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ], [
            'name.required'            => 'Judul proyek wajib diisi.',
            'client_id.required'       => 'Klien wajib dipilih.',
            'description.required'     => 'Deskripsi wajib diisi.',
            'budget_estimate.required' => 'Estimasi anggaran wajib diisi.',
        ]);

        $projectCode = 'PRJ-' . date('Y') . '-' . str_pad(Project::count() + 1, 3, '0', STR_PAD_LEFT);

        $project = Project::create([
            'project_code'    => $projectCode,
            'name'            => $request->name,
            'description'     => $request->description,
            'client_id'       => $request->client_id,
            'marketing_id'    => auth()->id(),
            'budget_estimate' => $request->budget_estimate,
            'location'        => $request->location,
            'maps_link'       => $request->maps_link,
            'other_info'      => $request->other_info,
            'status'          => 'review',
        ]);

        // Notifikasi ke semua owner
        $owners = User::where('role', 'owner')->get();
        foreach ($owners as $owner) {
            NotificationHelper::send(
                $owner->id,
                'Form Pengajuan Baru 📋',
                "Marketing \"{$project->marketing->name}\" mengajukan proyek \"{$project->name}\" untuk direview.",
                'review',
                route('owner.form-pengajuan.index')
            );
        }

        // Notif ke admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            NotificationHelper::send(
                $admin->id,
                'Form Pengajuan Baru',
                "Proyek \"{$project->name}\" telah diajukan oleh marketing dan menunggu review owner.",
                'review',
                route('admin.monitoring.index')
            );
        }

        // Upload foto dokumentasi
        if ($request->hasFile('foto')) {
            $progress = Projectprogress::create([
                'project_id'     => $project->id,
                'operational_id' => auth()->id(),
                'title'          => 'Dokumentasi Awal',
                'description'    => 'Foto dokumentasi pengajuan proyek.',
                'percentage'     => 0,
            ]);

            $path = $request->file('foto')->store('progress-photos', 'public');
            Projectphoto::create([
                'progress_id' => $progress->id,
                'file_path'   => $path,
                'caption'     => 'Dokumentasi awal proyek',
            ]);
        }

        return redirect()->route('marketing.riwayat.index')
            ->with('success', 'Form pengajuan berhasil dikirim.');
    }

    public function formRevisi()
    {
        $projects = Project::with(['klien.user'])
            ->where('marketing_id', auth()->id())
            ->where('status', 'revision')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('marketing.form-revisi.index', compact('projects'));
    }

    public function showRevisi(Project $project)
    {
        $project->load(['klien.user', 'notes.owner', 'progress.photos']);
        return view('marketing.form-revisi.show', compact('project'));
    }

    /**
     * Marketing memperbaiki data proyek (bukan sekadar ganti status)
     * lalu mengirimkannya kembali ke Owner untuk direview ulang.
     */
    public function kirimKembali(Request $request, Project $project)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'required',
            'budget_estimate' => 'required|numeric',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ], [
            'name.required'            => 'Judul proyek wajib diisi.',
            'description.required'     => 'Deskripsi wajib diisi.',
            'budget_estimate.required' => 'Estimasi anggaran wajib diisi.',
        ]);

        $project->update([
            'name'            => $request->name,
            'description'     => $request->description,
            'budget_estimate' => $request->budget_estimate,
            'location'        => $request->location,
            'maps_link'       => $request->maps_link,
            'other_info'      => $request->other_info,
            'status'          => 'review',
        ]);

        // Kalau ada foto baru, simpan sebagai dokumentasi revisi
        if ($request->hasFile('foto')) {
            $progress = Projectprogress::create([
                'project_id'     => $project->id,
                'operational_id' => auth()->id(),
                'title'          => 'Dokumentasi Revisi',
                'description'    => 'Foto dokumentasi setelah perbaikan form pengajuan.',
                'percentage'     => 0,
            ]);

            $path = $request->file('foto')->store('progress-photos', 'public');
            Projectphoto::create([
                'progress_id' => $progress->id,
                'file_path'   => $path,
                'caption'     => 'Dokumentasi revisi proyek',
            ]);
        }

        // Notif ke semua owner
        $owners = User::where('role', 'owner')->get();
        foreach ($owners as $owner) {
            NotificationHelper::send(
                $owner->id,
                'Form Revisi Dikirim Kembali 🔄',
                "Marketing telah memperbaiki dan mengirim kembali proyek \"{$project->name}\" untuk direview ulang.",
                'review',
                route('owner.form-pengajuan.index')
            );
        }

        // Notif ke admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            NotificationHelper::send(
                $admin->id,
                'Form Revisi Dikirim Kembali',
                "Proyek \"{$project->name}\" telah diperbaiki dan dikirim kembali setelah revisi.",
                'review',
                route('admin.monitoring.index')
            );
        }

        return redirect()->route('marketing.riwayat.index')
            ->with('success', 'Form berhasil diperbaiki dan dikirim kembali untuk direview.');
    }

    public function riwayat()
    {
        $projects = Project::with(['klien.user'])
            ->where('marketing_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('marketing.riwayat.index', compact('projects'));
    }
}