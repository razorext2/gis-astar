<?php

use App\Http\Controllers\Api\ApiAnnouncementController;
use App\Http\Controllers\Api\ApiAttendanceController;
use App\Http\Controllers\Api\ApiCollectController;
use App\Http\Controllers\Api\ApiCollectTaskController;
use App\Http\Controllers\Api\ApiDayoffController;
use App\Http\Controllers\Api\ApiPegawaiController;
use App\Http\Controllers\Api\ApiSalesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

// attendance
Route::get('get-attendance-data', [ApiAttendanceController::class, 'getAttendanceData'])->name('pegawai.getattendance');
Route::post('photo-regist-process', [ApiAttendanceController::class, 'photoRegistProcess'])->name('photo.registProcess');
Route::post('check-attendance', [ApiAttendanceController::class, 'checkAttendance']);

// pegawai
Route::get('getSixMonthsBefore', [ApiPegawaiController::class, 'getSixMonthsBefore']);
Route::get('getPegawai', [ApiPegawaiController::class, 'getPegawai']);
Route::get('pegawai-images/{id}', [ApiPegawaiController::class, 'getPegawaiImages']);
Route::get('getPegawaiData/{id}', [ApiPegawaiController::class, 'getPegawaiDataByLabel']);

// collect task
Route::patch('collect-task-api/{id}/reschedule', [ApiCollectTaskController::class, 'reschedule'])->name('collect-task-api.reschedule');
Route::patch('collect-task-api/{id}/validate', [ApiCollectTaskController::class, 'validateTask'])->name('collect-task-api.validate');
Route::patch('collect-task-api/{id}/assign', [ApiCollectTaskController::class, 'assignProcess'])->name('collect-task-api.assign');
Route::patch('collect-task-api/mass-assign', [ApiCollectTaskController::class, 'massAssignProcess'])->name('collect-task-api.mass-assign');
Route::get('collect-task-api/getSR/{no_sr}', [ApiCollectTaskController::class, 'getSR'])->name('collect-task-api.getsr');
Route::apiResource('collect-task-api', ApiCollectTaskController::class)->except(['index', 'show']);

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
Route::apiResource('announcement-api', ApiAnnouncementController::class)->only(['store', 'update', 'destroy']);

// api ke server utama
Route::post('proxy/server/attendance', function (Request $request) {
    $response = Http::post('https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=insertAttendance', [
        'kode_jari' => $request->input('kode_jari'),
    ]);

    return $response->json();
});
