<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\DB;

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
    ->dailyAt('09:30')
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
    ->dailyAt('09:50')
    ->name('Purge logs >7 hari')
    ->onOneServer()
    ->withoutOverlapping()
    ->evenInMaintenanceMode();

// Maintenance window harian (opsional)
Schedule::command('down')  // tambah opsi --retry/--secret kalau perlu
    ->timezone('Asia/Jakarta')
    ->dailyAt('09:20')
    ->name('Maintenance harian')
    ->onOneServer()
    ->evenInMaintenanceMode();

Schedule::command('up')
    ->timezone('Asia/Jakarta')
    ->name('Aplikasi live lagi')
    ->dailyAt('10:59')
    ->onOneServer()
    ->evenInMaintenanceMode();