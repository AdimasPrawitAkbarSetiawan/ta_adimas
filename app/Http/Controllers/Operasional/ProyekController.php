<?php

namespace App\Http\Controllers\Operasional;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Projectdetail;
use Illuminate\Http\Request;

class ProyekController extends Controller
{
    public function disetujui()
    {
        $daftar = Project::with(['klien.user', 'marketing'])
                         ->where('status', 'approved')
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('operasional.proyek-disetujui', compact('daftar'));
    }

    public function berjalan()
    {
        $daftar = Project::with(['klien.user', 'marketing'])
                         ->where('status', 'in_progress')
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('operasional.proyek-berjalan', compact('daftar'));
    }

    public function inputKebutuhan(Project $project)
    {
        $project->load(['klien.user', 'detail']);
        return view('operasional.input-kebutuhan', compact('project'));
    }

    public function simpanKebutuhan(Request $request, Project $project)
    {
        $request->validate([
            'lingkup_pekerjaan' => 'required',
            'tanggal_mulai'     => 'required|date',
            'tanggal_selesai'   => 'required|date|after_or_equal:tanggal_mulai',
        ], [
            'lingkup_pekerjaan.required' => 'Lingkup pekerjaan wajib diisi.',
            'tanggal_mulai.required'     => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required'   => 'Tanggal selesai wajib diisi.',
        ]);

        $material = [];
        if ($request->has('material_nama')) {
            foreach ($request->material_nama as $i => $nama) {
                if (!empty($nama)) {
                    $material[] = [
                        'nama'      => $nama,
                        'kebutuhan' => $request->material_kebutuhan[$i] ?? '',
                        'satuan'    => $request->material_satuan[$i] ?? '',
                    ];
                }
            }
        }

        $alatKerja = [];
        if ($request->has('alat_nama')) {
            foreach ($request->alat_nama as $i => $nama) {
                if (!empty($nama)) {
                    $alatKerja[] = [
                        'nama'   => $nama,
                        'jumlah' => $request->alat_jumlah[$i] ?? '',
                        'satuan' => $request->alat_satuan[$i] ?? '',
                    ];
                }
            }
        }

        Projectdetail::updateOrCreate(
            ['project_id' => $project->id],
            [
                'operational_id'  => auth()->id(),
                'scope_of_work'   => $request->lingkup_pekerjaan,
                'tools_materials' => $request->alat_material,
                'start_date'      => $request->tanggal_mulai,
                'end_date'        => $request->tanggal_selesai,
                'notes'           => $request->catatan,
                'material'        => json_encode($material),
                'alat_kerja'      => json_encode($alatKerja),
            ]
        );

        $project->update(['status' => 'in_progress']);

        return redirect()->route('operasional.proyek-berjalan.index')
                         ->with('sukses', 'Kebutuhan proyek berhasil disimpan.');
    }
}