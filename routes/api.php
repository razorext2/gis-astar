<?php

use App\Http\Controllers\Api\ApiCollectController;
use App\Http\Controllers\Api\ApiCollectTaskController;
use App\Http\Controllers\Api\ApiDayoffController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

// collect task
Route::apiResource('collect-task-api', ApiCollectTaskController::class);

// laporan kolektor
Route::apiResource('collect-api', ApiCollectController::class);
Route::patch('collect-api/{id}/confirm', [ApiCollectController::class, 'confirmCollect']);
Route::patch('collect-api/{id}/deny', [ApiCollectController::class, 'denyCollect']);

// pengajuan off
Route::apiResource('dayoff-api', ApiDayoffController::class);
Route::patch('dayoff-api/{id}/approve', [ApiDayoffController::class, 'approve']);
Route::patch('dayoff-api/{id}/deny', [ApiDayoffController::class, 'deny']);

// api ke server utama
Route::post('proxy/server/attendance', function (Request $request) {
    // 
    $response = Http::post('https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=insertAttendance', [
        'kode_jari' => $request->input('kode_jari'),
    ]);

    return $response->json();
});
