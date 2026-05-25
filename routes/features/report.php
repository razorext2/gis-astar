<?php

/** Goal: Define routes for Laporan (Report Export) feature, Caller: routes/web.php, Deps: ReportExportController */

use App\Http\Controllers\Report\ReportExportController;
use Illuminate\Support\Facades\Route;

Route::prefix('report')
    ->as('report.export.')
    ->group(function () {
        Route::get('absensi', [ReportExportController::class, 'absensi'])
            ->middleware('permission:attendance-approve')
            ->name('absensi');

        Route::get('cuti', [ReportExportController::class, 'cuti'])
            ->middleware('permission:leave-view-all')
            ->name('cuti');

        Route::get('piutang', [ReportExportController::class, 'piutang'])
            ->middleware('permission:collect-approve')
            ->name('piutang');

        Route::get('kolektor', [ReportExportController::class, 'kolektor'])
            ->middleware('permission:collect-approve')
            ->name('kolektor');

        Route::get('invoice', [ReportExportController::class, 'invoice'])
            ->middleware('permission:invoice-add')
            ->name('invoice');

        Route::get('spk', [ReportExportController::class, 'spk'])
            ->middleware('permission:spk-create')
            ->name('spk');

        Route::get('driver', [ReportExportController::class, 'driver'])
            ->middleware('permission:driver-approve')
            ->name('driver');

        Route::get('sales', [ReportExportController::class, 'sales'])
            ->middleware('permission:sales-approve')
            ->name('sales');
    });
