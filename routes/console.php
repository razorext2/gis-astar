<?php

/** Goal: Central console route scheduler, Caller: Kernel / Artisan Scheduler, Deps: Illuminate\Support\Facades\Schedule */

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Hapus notifikasi > 7 hari, sekali sehari
Schedule::call(function () {
    DB::table('notifications')
        ->where('created_at', '<', now()->subWeek())
        ->delete();
})
    ->timezone('Asia/Jakarta')
    ->dailyAt('00:30')
    ->name('Purge notifications >7 hari')
    ->onOneServer()
    ->withoutOverlapping()
    ->evenInMaintenanceMode();

// Hapus log > 7 hari, sekali sehari
Schedule::call(function () {
    DB::table('tb_log')
        ->where('created_at', '<', now()->subWeek())
        ->delete();
})
    ->timezone('Asia/Jakarta')
    ->dailyAt('00:50')
    ->name('Purge logs >7 hari')
    ->onOneServer()
    ->withoutOverlapping()
    ->evenInMaintenanceMode();

// Maintenance window harian (opsional)
Schedule::command('down')
    ->timezone('Asia/Jakarta')
    ->dailyAt('23:00')
    ->name('Maintenance harian')
    ->evenInMaintenanceMode();

Schedule::command('up')
    ->timezone('Asia/Jakarta')
    ->name('Aplikasi live lagi')
    ->dailyAt('02:00')
    ->evenInMaintenanceMode();

Schedule::command('sync:receivable-data')
    ->onOneServer()
    ->everyMinute();

Schedule::command('app:auto-submit-daily-report')
    ->timezone('Asia/Jakarta')
    ->name('Auto submit daily report')
    ->dailyAt('01:15')
    ->onOneServer()
    ->evenInMaintenanceMode();

// Cek status server setiap 5 menit
Schedule::command('server:check-status')
    ->everyFiveMinutes()
    ->name('Server status check')
    ->withoutOverlapping()
    ->runInBackground();

// Auto reject pengajuan cuti yang melebihi batas waktu approval
Schedule::command('app:auto-reject-expired-leave-requests')
    ->timezone('Asia/Jakarta')
    ->name('Auto reject expired leave requests')
    ->dailyAt('00:00')
    ->onOneServer()
    ->withoutOverlapping()
    ->evenInMaintenanceMode();

// Hapus berkas ekspor chatbot yang lebih lama dari 24 jam, dijalankan setiap hari pukul 01:30 WIB
Schedule::call(function () {
    $files = \Illuminate\Support\Facades\Storage::disk('public')->files('exports');
    foreach ($files as $file) {
        $lastModified = \Illuminate\Support\Facades\Storage::disk('public')->lastModified($file);
        if (time() - $lastModified > 86400) { // 24 jam
            \Illuminate\Support\Facades\Storage::disk('public')->delete($file);
        }
    }
})
    ->timezone('Asia/Jakarta')
    ->dailyAt('01:30')
    ->name('Purge chatbot export files >24 jam')
    ->onOneServer()
    ->withoutOverlapping()
    ->evenInMaintenanceMode();
