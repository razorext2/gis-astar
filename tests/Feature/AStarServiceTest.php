<?php

use App\DTOs\AStarResult;
use App\Models\RumahSakit;
use App\Services\AStarService;

it('calculates accurate haversine distance', function () {
    $service = new AStarService;

    // Jarak Jakarta (Monas) ke Bandung (Gedung Sate) sekitar 115-120 km
    $latMonas = -6.1754;
    $lngMonas = 106.8272;
    $latGedungSate = -6.9025;
    $lngGedungSate = 107.6188;

    $distance = $service->haversine($latMonas, $lngMonas, $latGedungSate, $lngGedungSate);

    expect($distance)->toBeGreaterThan(110);
    expect($distance)->toBeLessThan(130);
});

it('finds the best hospital and ranks correctly', function () {
    $service = new AStarService;

    // Buat RS dummy
    $rs1 = RumahSakit::factory()->create([
        'nama_rumah_sakit' => 'RS Dekat',
        'latitude' => -6.1800,
        'longitude' => 106.8200,
    ]);

    $rs2 = RumahSakit::factory()->create([
        'nama_rumah_sakit' => 'RS Jauh',
        'latitude' => -6.3000,
        'longitude' => 106.9000,
    ]);

    $hospitals = collect([$rs1, $rs2]);

    // Koordinat pasien dekat dengan RS Dekat
    $pasienLat = -6.1754;
    $pasienLng = 106.8272;

    $result = $service->findBestHospital($pasienLat, $pasienLng, $hospitals);

    expect($result)->toBeInstanceOf(AStarResult::class);
    expect($result->bestHospital->id_rumah_sakit)->toBe($rs1->id_rumah_sakit);
    expect($result->allRanked[0]['hospital']->id_rumah_sakit)->toBe($rs1->id_rumah_sakit);
    expect($result->allRanked[1]['hospital']->id_rumah_sakit)->toBe($rs2->id_rumah_sakit);
    expect($result->totalDistance)->toBeGreaterThan(0);
});
