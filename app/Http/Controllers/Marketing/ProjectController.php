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

        // Kirim email & notifikasi ke semua owner
        $owners = User::where('role', 'owner')->get();
        foreach ($owners as $owner) {
            NotificationHelper::send(
                $owner->id,
                'Form Pengajuan Baru 📋',
                "Marketing \"{$project->marketing->name}\" mengajukan proyek \"{$project->name}\" untuk direview.",
                'review'
            );
        }

        // Notif ke admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            NotificationHelper::send(
                $admin->id,
                'Form Pengajuan Baru',
                "Proyek \"{$project->name}\" telah diajukan oleh marketing dan menunggu review owner.",
                'review'
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

    public function kirimKembali(Request $request, Project $project)
    {
        $project->update(['status' => 'review']);

        // Notif ke semua owner
        $owners = User::where('role', 'owner')->get();
        foreach ($owners as $owner) {
            NotificationHelper::send(
                $owner->id,
                'Form Revisi Dikirim Kembali 🔄',
                "Marketing telah mengirim kembali proyek \"{$project->name}\" setelah revisi untuk direview ulang.",
                'review'
            );
        }

        // Notif ke admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            NotificationHelper::send(
                $admin->id,
                'Form Revisi Dikirim Kembali',
                "Proyek \"{$project->name}\" telah dikirim kembali setelah revisi.",
                'review'
            );
        }

        return redirect()->route('marketing.riwayat.index')
            ->with('success', 'Form berhasil dikirim kembali untuk direview.');
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