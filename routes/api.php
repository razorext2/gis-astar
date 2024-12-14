<?php

use App\Http\Controllers\Api\ApiCollectController;
use App\Http\Controllers\Api\ApiDayoffController;
use App\Http\Controllers\PegawaiController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;


Route::apiResource('collectors', ApiCollectController::class);
Route::patch('collectors/{collector}/confirm', [ApiCollectController::class, 'confirmCollect']);
Route::patch('collectors/{collector}/deny', [ApiCollectController::class, 'denyCollect']);

Route::apiResource('dayoff', ApiDayoffController::class);

// api ke server utama
Route::post('proxy/server/attendance', function (Request $request) {
    // 
    $response = Http::post('https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=insertAttendance', [
        'kode_jari' => $request->input('kode_jari'),
    ]);

    return $response->json();
});
