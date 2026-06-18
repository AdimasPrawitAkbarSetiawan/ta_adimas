<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key');
        return view('admin.setting.index', compact('settings'));
    }

    public function backupIndex()
    {
        return view('admin.backup.index');
    }

    public function update(Request $request)
{
    // Simpan app_name kalau ada
    if ($request->filled('app_name')) {
        Setting::set('app_name', $request->app_name);
    }

    // Simpan app_color kalau ada
    if ($request->filled('app_color')) {
        Setting::set('app_color', $request->app_color);
    }

    // Simpan company info kalau ada
    if ($request->filled('company_name')) {
        Setting::set('company_name',    $request->company_name);
        Setting::set('company_address', $request->company_address);
        Setting::set('company_phone',   $request->company_phone);
        Setting::set('company_email',   $request->company_email);
    }

    return redirect()->route('admin.settings.index')
                     ->with('sukses', 'Pengaturan berhasil disimpan.');
}

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ], [
            'logo.required' => 'File logo wajib dipilih.',
            'logo.image'    => 'File harus berupa gambar.',
            'logo.mimes'    => 'Format harus PNG atau JPG.',
            'logo.max'      => 'Ukuran maksimal 2MB.',
        ]);

        $path = $request->file('logo')->storeAs('public/images', 'logo_simppro.png');

        $sourcePath = storage_path('app/public/images/logo_simppro.png');
        $destPath   = public_path('images/logo_simppro.png');
        if (!is_dir(public_path('images'))) mkdir(public_path('images'), 0755, true);
        copy($sourcePath, $destPath);

        Setting::set('app_logo', 'images/logo_simppro.png');

        return redirect()->route('admin.settings.index')
                         ->with('sukses', 'Logo berhasil diperbarui.');
    }

    public function backupDatabase(Request $request)
    {
        if ($request->type === 'database') {
            $filename = 'backup_db_' . date('Ymd_His') . '.sql';
            $host     = config('database.connections.mysql.host');
            $user     = config('database.connections.mysql.username');
            $pass     = config('database.connections.mysql.password');
            $db       = config('database.connections.mysql.database');
            $path     = storage_path("app/{$filename}");

            $mysqldump = 'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump.exe';
$command = "\"{$mysqldump}\" --host={$host} --user={$user} --password={$pass} {$db} > \"{$path}\"";
exec($command);

            return response()->download($path, $filename)->deleteFileAfterSend(true);
        }

        return redirect()->route('admin.settings.index')
                         ->with('error', 'Tipe backup tidak dikenali.');
    }

    public function backupSourceCode()
    {
        $zipFilename = 'backup_sourcecode_' . date('Ymd_His') . '.zip';
        $zipPath     = storage_path("app/{$zipFilename}");

        $zip = new \ZipArchive();

        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return redirect()->route('admin.settings.index')
                             ->with('error', 'Gagal membuat file zip.');
        }

        $rootPath = base_path();
        $excludeFolders = ['vendor', 'node_modules', '.git', 'storage/logs', 'storage/framework'];

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($rootPath, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if (!$file->isFile()) continue;
            $filePath     = $file->getRealPath();
            $relativePath = substr($filePath, strlen($rootPath) + 1);
            foreach ($excludeFolders as $exclude) {
                if (str_starts_with($relativePath, $exclude)) continue 2;
            }
            $zip->addFile($filePath, $relativePath);
        }

        $zip->close();

        return response()->download($zipPath, $zipFilename)->deleteFileAfterSend(true);
    }
}