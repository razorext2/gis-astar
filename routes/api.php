<?php

use App\Http\Controllers\Api\ApiCollectController;
use App\Http\Controllers\Api\ApiCollectTaskController;
use App\Http\Controllers\Api\ApiDayoffController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

// collect task
Route::patch('collect-task-api/{id}/validate', [ApiCollectTaskController::class, 'validateTask'])->name('collect-task-api.validate');
Route::patch('collect-task-api/{id}/assign', [ApiCollectTaskController::class, 'assignProcess'])->name('collect-task-api.assign');
Route::patch('collect-task-api/mass-assign', [ApiCollectTaskController::class, 'massAssignProcess'])->name('collect-task-api.mass-assign');
Route::get('collect-task-api/getSR/{id}', [ApiCollectTaskController::class, 'getSR'])->name('collect-task-api.getsr');
Route::apiResource('collect-task-api', ApiCollectTaskController::class)->except(['index', 'show']);

// laporan kolektor
Route::patch('collect-api/{id}/confirm', [ApiCollectController::class, 'confirmCollect'])->name('collect-api.confirm');
Route::patch('collect-api/{id}/deny', [ApiCollectController::class, 'denyCollect'])->name('collect-api.deny');
Route::apiResource('collect-api', ApiCollectController::class)->except(['index', 'store', 'show']);

// pengajuan off
Route::patch('dayoff-api/{id}/approve', [ApiDayoffController::class, 'approve'])->name('dayoff-api.approve');
Route::patch('dayoff-api/{id}/deny', [ApiDayoffController::class, 'deny'])->name('dayoff-api.deny');
Route::apiResource('dayoff-api', ApiDayoffController::class)->except(['index', 'show']);

// api ke server utama
Route::post('proxy/server/attendance', function (Request $request) {
    $response = Http::post('https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=insertAttendance', [
        'kode_jari' => $request->input('kode_jari'),
    ]);

    return $response->json();
});
