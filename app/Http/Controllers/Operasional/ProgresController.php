<?php

namespace App\Http\Controllers\Operasional;

use App\Helpers\NotificationHelper;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Projectprogress;
use App\Models\Projectphoto;
use Illuminate\Http\Request;

class ProgresController extends Controller
{
    public function create(Project $project)
    {
        $project->load(['klien.user', 'progress.photos']);
        return view('operasional.input-progres', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'keterangan'      => 'required',
            'persentase'      => 'required|integer|min:0|max:100',
            'tanggal_laporan' => 'required|date',
            'foto'            => 'nullable',
            'foto.*'          => 'image|mimes:jpg,jpeg,png|max:5120',
        ], [
            'judul.required'           => 'Judul progres wajib diisi.',
            'keterangan.required'      => 'Keterangan wajib diisi.',
            'persentase.required'      => 'Persentase wajib diisi.',
            'persentase.max'           => 'Persentase maksimal 100.',
            'tanggal_laporan.required' => 'Tanggal laporan wajib diisi.',
        ]);

        $progres = Projectprogress::create([
            'project_id'      => $project->id,
            'operational_id'  => auth()->id(),
            'title'           => $request->judul,
            'description'     => $request->keterangan,
            'percentage'      => $request->persentase,
            'tanggal_laporan' => $request->tanggal_laporan,
        ]);

        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $foto) {
                $path = $foto->store('progress-photos', 'public');
                Projectphoto::create([
                    'progress_id' => $progres->id,
                    'file_path'   => $path,
                    'caption'     => $request->judul,
                ]);
            }
        }

        if ($request->persentase == 100) {
            $project->update(['status' => 'completed']);

            // Notif proyek selesai ke semua owner & admin
            $owners = User::where('role', 'owner')->get();
            foreach ($owners as $owner) {
                NotificationHelper::send(
                    $owner->id,
                    'Proyek Selesai 🎉',
                    "Proyek \"{$project->name}\" telah selesai 100%.",
                    'completed'
                );
            }
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                NotificationHelper::send(
                    $admin->id,
                    'Proyek Selesai',
                    "Proyek \"{$project->name}\" telah selesai 100%.",
                    'completed'
                );
            }
        }

        // Kirim email & notifikasi progres ke semua owner
        $owners = User::where('role', 'owner')->get();
        foreach ($owners as $owner) {
            NotificationHelper::send(
                $owner->id,
                'Update Progres Proyek 📊',
                "Proyek \"{$project->name}\" diupdate ke {$request->persentase}%. Judul: {$request->judul}",
                'progress'
            );
        }

        // Kirim email & notifikasi ke klien
        $project->load('klien.user');
        if ($project->klien && $project->klien->user) {
            NotificationHelper::send(
                $project->klien->user->id,
                'Update Progres Proyek 📊',
                "Proyek \"{$project->name}\" diupdate ke {$request->persentase}%. Judul: {$request->judul}",
                'progress'
            );
        }

        // Notif ke admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            NotificationHelper::send(
                $admin->id,
                'Update Progres Proyek',
                "Operasional mengupdate progres proyek \"{$project->name}\" ke {$request->persentase}%.",
                'progress'
            );
        }

        return redirect()->route('operasional.proyek-berjalan.index')
                         ->with('sukses', 'Progres berhasil diupdate.');
    }
}