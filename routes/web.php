<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;

Route::middleware('guest')->group(function () {
    Route::get('/',       [AuthController::class, 'showLogin'])->name('login');
    Route::get('/reset-password', [AuthController::class, 'showReset'])->name('reset.show')->middleware('guest');
    Route::post('/reset-password', [AuthController::class, 'reset'])->name('reset.post')->middleware('guest');
    Route::get('/login',  [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
     ->middleware('auth')
     ->name('logout');

Route::middleware(['auth', 'role:admin'])
     ->prefix('admin')
     ->name('admin.')
     ->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('user', UserController::class)->except(['show']);
    Route::get('/monitoring', [\App\Http\Controllers\Admin\MonitoringController::class, 'index'])->name('monitoring.index');
    Route::get('/monitoring/{project}', [\App\Http\Controllers\Admin\MonitoringController::class, 'show'])->name('monitoring.show');

    // Settings
    Route::get('/settings',              [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings',             [SettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/logo',        [SettingController::class, 'updateLogo'])->name('settings.logo');

    // Backup (halaman terpisah)
    Route::get('/backup',                [SettingController::class, 'backupIndex'])->name('backup.index');
    Route::post('/backup/database',      [SettingController::class, 'backupDatabase'])->name('settings.backup');
    Route::post('/backup/source',        [SettingController::class, 'backupSourceCode'])->name('settings.backup-source');
});

Route::middleware(['auth', 'role:owner'])
     ->prefix('owner')
     ->name('owner.')
     ->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Owner\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/form-pengajuan', [\App\Http\Controllers\Owner\ReviewFormController::class, 'index'])->name('form-pengajuan.index');
    Route::get('/form-pengajuan/{project}', [\App\Http\Controllers\Owner\ReviewFormController::class, 'show'])->name('form-pengajuan.show');
    Route::post('/form-pengajuan/{project}/approve', [\App\Http\Controllers\Owner\ReviewFormController::class, 'approve'])->name('form-pengajuan.approve');
    Route::post('/form-pengajuan/{project}/reject', [\App\Http\Controllers\Owner\ReviewFormController::class, 'reject'])->name('form-pengajuan.reject');
    Route::post('/form-pengajuan/{project}/revisi', [\App\Http\Controllers\Owner\ReviewFormController::class, 'revisi'])->name('form-pengajuan.revisi');
    Route::get('/form-revisi', [\App\Http\Controllers\Owner\ReviewFormController::class, 'formRevisi'])->name('form-revisi.index');
    Route::get('/monitoring', [\App\Http\Controllers\Owner\MonitoringController::class, 'index'])->name('monitoring.index');
    Route::get('/monitoring/{project}', [\App\Http\Controllers\Owner\MonitoringController::class, 'show'])->name('monitoring.show');
    Route::get('/riwayat-keputusan', [\App\Http\Controllers\Owner\RiwayatKeputusanController::class, 'index'])->name('riwayat-keputusan.index');
    Route::get('/riwayat-keputusan/{project}', [\App\Http\Controllers\Owner\RiwayatKeputusanController::class, 'show'])->name('riwayat-keputusan.show');
    Route::get('/kebutuhan/{project}',         [\App\Http\Controllers\Owner\KebutuhanController::class, 'show'])->name('kebutuhan.show');
    Route::post('/kebutuhan/{project}/approve', [\App\Http\Controllers\Owner\KebutuhanController::class, 'approve'])->name('kebutuhan.approve');
    Route::post('/kebutuhan/{project}/revisi',  [\App\Http\Controllers\Owner\KebutuhanController::class, 'revisi'])->name('kebutuhan.revisi');
    Route::get('/kebutuhan',                    [\App\Http\Controllers\Owner\KebutuhanController::class, 'index'])->name('kebutuhan.index');
    Route::get('/kebutuhan/{project}',          [\App\Http\Controllers\Owner\KebutuhanController::class, 'show'])->name('kebutuhan.show');
    Route::post('/kebutuhan/{project}/approve', [\App\Http\Controllers\Owner\KebutuhanController::class, 'approve'])->name('kebutuhan.approve');
    Route::post('/kebutuhan/{project}/revisi',  [\App\Http\Controllers\Owner\KebutuhanController::class, 'revisi'])->name('kebutuhan.revisi');
});

Route::middleware(['auth', 'role:marketing'])
     ->prefix('marketing')
     ->name('marketing.')
     ->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Marketing\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/form-pengajuan', [\App\Http\Controllers\Marketing\ProjectController::class, 'create'])->name('form-pengajuan');
    Route::post('/form-pengajuan', [\App\Http\Controllers\Marketing\ProjectController::class, 'store'])->name('form-pengajuan.store');
    Route::get('/form-revisi', [\App\Http\Controllers\Marketing\ProjectController::class, 'formRevisi'])->name('form-revisi.index');
    Route::get('/form-revisi/{project}', [\App\Http\Controllers\Marketing\ProjectController::class, 'showRevisi'])->name('form-revisi.show');
    Route::post('/form-revisi/{project}/kirim', [\App\Http\Controllers\Marketing\ProjectController::class, 'kirimKembali'])->name('form-revisi.kirim');
    Route::get('/riwayat', [\App\Http\Controllers\Marketing\ProjectController::class, 'riwayat'])->name('riwayat.index');
});

Route::middleware(['auth', 'role:operasional'])
     ->prefix('operasional')
     ->name('operasional.')
     ->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Operasional\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/proyek-disetujui', [\App\Http\Controllers\Operasional\ProyekController::class, 'disetujui'])->name('proyek-disetujui.index');
    Route::get('/kebutuhan-direvisi', [\App\Http\Controllers\Operasional\ProyekController::class, 'kebutuhanDirevisi'])->name('kebutuhan-direvisi.index');
    Route::get('/proyek-berjalan', [\App\Http\Controllers\Operasional\ProyekController::class, 'berjalan'])->name('proyek-berjalan.index');
    Route::get('/input-kebutuhan/{project}', [\App\Http\Controllers\Operasional\ProyekController::class, 'inputKebutuhan'])->name('input-kebutuhan.show');
    Route::post('/input-kebutuhan/{project}', [\App\Http\Controllers\Operasional\ProyekController::class, 'simpanKebutuhan'])->name('input-kebutuhan.store');
    Route::get('/input-progres/{project}', [\App\Http\Controllers\Operasional\ProgresController::class, 'create'])->name('input-progres.create');
    Route::post('/input-progres/{project}', [\App\Http\Controllers\Operasional\ProgresController::class, 'store'])->name('input-progres.store');
});

Route::middleware(['auth', 'role:klien'])
     ->prefix('klien')
     ->name('klien.')
     ->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Klien\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/progres-proyek/{project}', [\App\Http\Controllers\Klien\DashboardController::class, 'show'])->name('progres.show');
    Route::get('/progres-proyek/{project}/cetak', [\App\Http\Controllers\Klien\DashboardController::class, 'cetakProgress'])->name('progres.cetak');
});

Route::middleware('auth')->group(function () {
    Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/messages/{userId}', [App\Http\Controllers\ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/send', [App\Http\Controllers\ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/unread', [App\Http\Controllers\ChatController::class, 'unreadCount'])->name('chat.unread');
    Route::get('/chat/users', [App\Http\Controllers\ChatController::class, 'users'])->name('chat.users');

    // Notifikasi
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::get('/notifications/unread', [App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('notifications.unread');
});