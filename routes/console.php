<?php

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
Schedule::command('down')  // tambah opsi --retry/--secret kalau perlu
    ->timezone('Asia/Jakarta')
    ->dailyAt('23:00')
    ->name('Maintenance harian')
    ->onOneServer()
    ->evenInMaintenanceMode();

Schedule::command('up')
    ->timezone('Asia/Jakarta')
    ->name('Aplikasi live lagi')
    ->dailyAt('02:00')
    ->onOneServer()
    ->evenInMaintenanceMode();

Schedule::command('sync:receivable-data')
    ->everyMinute();

Schedule::command('app:auto-submit-daily-report')
    ->timezone('Asia/Jakarta')
    ->name('Auto submit daily report')
    ->dailyAt('01:15')
    ->onOneServer()
    ->evenInMaintenanceMode();
