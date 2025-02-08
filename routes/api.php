<?php

use App\Http\Controllers\Api\ApiAnnouncementController;
use App\Http\Controllers\Api\ApiAttendanceController;
use App\Http\Controllers\Api\ApiBackupController;
use App\Http\Controllers\Api\ApiCollectController;
use App\Http\Controllers\Api\ApiCollectIdyPpnController;
use App\Http\Controllers\Api\ApiCollectTaskController;
use App\Http\Controllers\Api\ApiCollectTaskPpnController;
use App\Http\Controllers\Api\ApiDayoffController;
use App\Http\Controllers\Api\ApiPegawaiController;
use App\Http\Controllers\Api\ApiSalesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

// public API
Route::post('photo-regist-process', [ApiAttendanceController::class, 'photoRegistProcess'])->name('photo.registProcess');
Route::post('check-attendance', [ApiAttendanceController::class, 'checkAttendance']);
Route::get('getPegawai', [ApiPegawaiController::class, 'getPegawai']); // harusnya ini gausah
Route::get('pegawai-images/{id}', [ApiPegawaiController::class, 'getPegawaiImages']); // sama ini, soalnya ini api public
Route::get('getPegawaiData/{id}', [ApiPegawaiController::class, 'getPegawaiDataByLabel']);

// public API post attendance ke server utama
Route::post('proxy/server/attendance', function (Request $request) {
    $response = Http::post('https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=insertAttendance', [
        'kode_jari' => $request->input('kode_jari'),
    ]);

    return $response->json();
});

Route::middleware('auth:sanctum')->group(function () {
    // private API using token, harus auth. 
    Route::get('get-attendance-data', [ApiAttendanceController::class, 'getAttendanceData'])->name('pegawai.getattendance');

    // pegawai
    Route::get('getSixMonthsBefore', [ApiPegawaiController::class, 'getSixMonthsBefore']);

    // collect task
    Route::patch('collect-task-api/{id}/reschedule', [ApiCollectTaskController::class, 'reschedule'])->name('collect-task-api.reschedule');
    Route::patch('collect-task-api/{id}/validate', [ApiCollectTaskController::class, 'validateTask'])->name('collect-task-api.validate');
    Route::patch('collect-task-api/{id}/assign', [ApiCollectTaskController::class, 'assignProcess'])->name('collect-task-api.assign');
    Route::patch('collect-task-api/mass-assign', [ApiCollectTaskController::class, 'massAssignProcess'])->name('collect-task-api.mass-assign');
    Route::get('collect-task-api/getSR/{no_sr}', [ApiCollectTaskController::class, 'getSR'])->name('collect-task-api.getsr')->middleware('auth:sanctum');
    Route::apiResource('collect-task-api', ApiCollectTaskController::class)->except(['index', 'show']);

    // collect task ppn
    Route::patch('collect-task-ppn-api/{id}/reschedule', [ApiCollectTaskPpnController::class, 'reschedule'])->name('collect-task-ppn-api.reschedule');
    Route::patch('collect-task-ppn-api/{id}/validate', [ApiCollectTaskPpnController::class, 'validateTask'])->name('collect-task-ppn-api.validate');
    Route::patch('collect-task-ppn-api/{id}/assign', [ApiCollectTaskPpnController::class, 'assignProcess'])->name('collect-task-ppn-api.assign');
    Route::patch('collect-task-ppn-api/mass-assign', [ApiCollectTaskPpnController::class, 'massAssignProcess'])->name('collect-task-ppn-api.mass-assign');
    Route::get('collect-task-ppn-api/getSR/{no_sr}', [ApiCollectTaskPpnController::class, 'getSR'])->name('collect-task-ppn-api.getsr');
    Route::apiResource('collect-task-ppn-api', ApiCollectTaskPpnController::class)->except(['index', 'show']);

    // collect idy ppn
    Route::patch('collect-idy-ppn-api/{id}/reschedule', [ApiCollectIdyPpnController::class, 'reschedule'])->name('collect-idy-ppn-api.reschedule');
    Route::patch('collect-idy-ppn-api/{id}/validate', [ApiCollectIdyPpnController::class, 'validateTask'])->name('collect-idy-ppn-api.validate');
    Route::patch('collect-idy-ppn-api/{id}/assign', [ApiCollectIdyPpnController::class, 'assignProcess'])->name('collect-idy-ppn-api.assign');
    Route::patch('collect-idy-ppn-api/mass-assign', [ApiCollectIdyPpnController::class, 'massAssignProcess'])->name('collect-idy-ppn-api.mass-assign');
    Route::get('collect-idy-ppn-api/getSR/{no_sr}', [ApiCollectIdyPpnController::class, 'getSR'])->name('collect-idy-ppn-api.getsr');
    Route::apiResource('collect-idy-ppn-api', ApiCollectIdyPpnController::class)->except(['index', 'show']);

    // laporan kolektor
    Route::patch('collect-api/{id}/confirm', [ApiCollectController::class, 'confirmCollect'])->name('collect-api.confirm');
    Route::patch('collect-api/{id}/deny', [ApiCollectController::class, 'denyCollect'])->name('collect-api.deny');
    Route::apiResource('collect-api', ApiCollectController::class)->except(['index', 'store', 'show']);

    // laporan sales
    Route::patch('sales-api/{id}/confirm', [ApiSalesController::class, 'confirm'])->name('sales-api.confirm');
    Route::patch('sales-api/{id}/deny', [ApiSalesController::class, 'deny'])->name('sales-api.deny');
    Route::apiResource('sales-api', ApiSalesController::class)->only(['store', 'update', 'destroy']);

    // pengajuan off
    Route::patch('dayoff-api/{id}/approve', [ApiDayoffController::class, 'approve'])->name('dayoff-api.approve');
    Route::patch('dayoff-api/{id}/deny', [ApiDayoffController::class, 'deny'])->name('dayoff-api.deny');
    Route::apiResource('dayoff-api', ApiDayoffController::class)->except(['index', 'show']);

    // announcement
    Route::patch('announcement-api/{id}/state', [ApiAnnouncementController::class, 'changeState'])->name('announcement-api.change-state');
    Route::apiResource('announcement-api', ApiAnnouncementController::class)->only(['store', 'show', 'update', 'destroy']);

    // backup
    Route::apiResource('backup-api', ApiBackupController::class)->only(['store', 'update', 'destroy', 'show']);
});
