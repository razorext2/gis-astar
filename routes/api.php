<?php

use App\Http\Controllers\Api\ApiAnnouncementController;
use App\Http\Controllers\Api\ApiAttendanceController;
use App\Http\Controllers\Api\ApiCollectController;
use App\Http\Controllers\Api\ApiCollectIdyPpnController;
use App\Http\Controllers\Api\ApiCollectTaskController;
use App\Http\Controllers\Api\ApiCollectTaskPpnController;
use App\Http\Controllers\Api\ApiDriverController;
use App\Http\Controllers\Api\ApiPegawaiController;
use App\Http\Controllers\Api\ApiSalesController;
use App\Http\Controllers\BigEventController;
use App\Http\Controllers\TechnicianController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

// public API
Route::post('photo-regist-process', [ApiAttendanceController::class, 'photoRegistProcess'])->name('photo.registProcess');
Route::post('check-attendance', [ApiAttendanceController::class, 'checkAttendance']);
Route::get('pegawai-images/{id}', [ApiPegawaiController::class, 'getPegawaiImages']);
Route::get('getPegawaiData/{id}', [ApiPegawaiController::class, 'getPegawaiDataByLabel']);

// ini untuk api partisipan event jika customer klik
Route::get('event/{event}/{participant}/visitor', [BigEventController::class, 'storeParticipantVisitor'])->name('event.participant.api');

// public API post attendance ke server utama
Route::post('proxy/server/attendance', function (Request $request) {
    $kodeJari = $request->input('kode_jari');
    $user = \App\Models\User::where('kode_pegawai', $kodeJari)->first();

    $url = ($user && $user->hasRole('Employee-Agrotec'))
        ? 'https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=insertAttendanceAgrotec'
        : 'https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=insertAttendance';

    $response = Http::post($url, [
        'kode_jari' => $kodeJari,
    ]);

    return $response->json();
});

Route::middleware(['auth:sanctum', 'throttle:high'])->group(function () {
    // attendance api
    Route::post('facerecognition/verify', [ApiAttendanceController::class, 'verify'])->name('facerecognition.verify');

    // private API using token, harus auth.
    Route::get('get-attendance-data', [ApiAttendanceController::class, 'getAttendanceData'])->name('pegawai.getattendance');

    // pegawai
    Route::get('getSixMonthsBefore', [ApiPegawaiController::class, 'getSixMonthsBefore']);

    // collect task
    Route::patch('collect-task-api/{id}/reschedule', [ApiCollectTaskController::class, 'reschedule'])->name('collect-task-api.reschedule');
    Route::patch('collect-task-api/{id}/validate', [ApiCollectTaskController::class, 'validateTask'])->name('collect-task-api.validate');
    Route::patch('collect-task-api/{id}/assign', [ApiCollectTaskController::class, 'assignProcess'])->name('collect-task-api.assign');
    Route::get('collect-task-api/getSR/{no_sr}', [ApiCollectTaskController::class, 'getSR'])
        ->name('collect-task-api.getsr')
        ->middleware('auth:sanctum');
    Route::apiResource('collect-task-api', ApiCollectTaskController::class)->except(['index', 'show']);

    // collect task ppn
    Route::patch('collect-task-ppn-api/{id}/reschedule', [ApiCollectTaskPpnController::class, 'reschedule'])->name('collect-task-ppn-api.reschedule');
    Route::patch('collect-task-ppn-api/{id}/validate', [ApiCollectTaskPpnController::class, 'validateTask'])->name('collect-task-ppn-api.validate');
    Route::patch('collect-task-ppn-api/{id}/assign', [ApiCollectTaskPpnController::class, 'assignProcess'])->name('collect-task-ppn-api.assign');
    Route::get('collect-task-ppn-api/getSR/{no_sr}', [ApiCollectTaskPpnController::class, 'getSR'])->name('collect-task-ppn-api.getsr');
    Route::apiResource('collect-task-ppn-api', ApiCollectTaskPpnController::class)->except(['index', 'show']);

    // collect idy ppn
    Route::patch('collect-idy-ppn-api/{id}/reschedule', [ApiCollectIdyPpnController::class, 'reschedule'])->name('collect-idy-ppn-api.reschedule');
    Route::patch('collect-idy-ppn-api/{id}/validate', [ApiCollectIdyPpnController::class, 'validateTask'])->name('collect-idy-ppn-api.validate');
    Route::patch('collect-idy-ppn-api/{id}/assign', [ApiCollectIdyPpnController::class, 'assignProcess'])->name('collect-idy-ppn-api.assign');
    Route::get('collect-idy-ppn-api/getSR/{no_sr}', [ApiCollectIdyPpnController::class, 'getSR'])->name('collect-idy-ppn-api.getsr');
    Route::apiResource('collect-idy-ppn-api', ApiCollectIdyPpnController::class)->except(['index', 'show']);

    // laporan kolektor
    Route::patch('collect-api/{id}/confirm', [ApiCollectController::class, 'confirmCollect'])->name('collect-api.confirm');
    Route::patch('collect-api/{id}/deny', [ApiCollectController::class, 'denyCollect'])->name('collect-api.deny');
    Route::patch('collect-api/{id}/revision', [ApiCollectController::class, 'revisionCollect'])->name('collect-api.revision');
    Route::apiResource('collect-api', ApiCollectController::class)->except(['index', 'store', 'show']);

    // laporan sales
    Route::get('sales-api/{id}', [ApiSalesController::class, 'getById'])->name('sales-api.getbyid');
    Route::patch('sales-api/{id}/confirm', [ApiSalesController::class, 'confirm'])->name('sales-api.confirm');
    Route::patch('sales-api/{id}/deny', [ApiSalesController::class, 'deny'])->name('sales-api.deny');
    Route::apiResource('sales-api', ApiSalesController::class)->only(['store', 'update', 'destroy']);

    // laporan driver
    Route::post('driver-api/update-assign', [ApiDriverController::class, 'assignUpdate'])->name('driver-api.update-assign');
    Route::get('driver-api/{id}', [ApiDriverController::class, 'getById'])->name('driver-api.getbyid');
    Route::patch('driver-api/{id}/confirm', [ApiDriverController::class, 'confirm'])->name('driver-api.confirm');
    Route::patch('driver-api/{id}/deny', [ApiDriverController::class, 'deny'])->name('driver-api.deny');
    Route::patch('driver-api/{id}/revision', [ApiDriverController::class, 'revision'])->name('driver-api.revision');
    Route::apiResource('driver-api', ApiDriverController::class)->only(['store', 'update']);

    // announcement
    Route::patch('announcement-api/{id}/state', [ApiAnnouncementController::class, 'changeState'])->name('announcement-api.change-state');
    Route::apiResource('announcement-api', ApiAnnouncementController::class)->only(['store', 'show', 'update', 'destroy']);

    // technician
    Route::patch('technician/{id}/confirm', [TechnicianController::class, 'confirm'])->name('technician.confirm');
    Route::patch('technician/{id}/deny', [TechnicianController::class, 'deny'])->name('technician.deny');
    Route::patch('technician/{id}/revision', [TechnicianController::class, 'revision'])->name('technician.revision');

    // map distribution
    Route::get('map-distribution', [\App\Http\Controllers\AttendanceController::class, 'getDistribution'])->name('map-distribution');
});
