<?php

use App\Models\RumahSakit;
use App\Services\AStarService;
use App\Services\OsrmService;
use Illuminate\Support\Facades\Http;

it('handles empty destination collection gracefully in OsrmService', function () {
    $service = new OsrmService;
    $result = $service->getDistancesAndDurations(3.5820, 98.6490, []);

    expect($result)->toBeArray()->toBeEmpty();
});

it('calculates distances and durations using mocked OSRM Table API', function () {
    $rs1 = RumahSakit::factory()->create([
        'latitude' => 3.5870,
        'longitude' => 98.6437,
    ]);

    $rs2 = RumahSakit::factory()->create([
        'latitude' => 3.5985,
        'longitude' => 98.6610,
    ]);

    Http::fake([
        '*/table/v1/driving/*' => Http::response([
            'code' => 'Ok',
            'distances' => [
                [0, 1200, 2500], // meters
            ],
            'durations' => [
                [0, 180, 420], // seconds
            ],
        ], 200),
    ]);

    $service = new OsrmService;
    $metrics = $service->getDistancesAndDurations(3.5820, 98.6490, [$rs1, $rs2]);

    expect($metrics)->toHaveKey($rs1->id_rumah_sakit);
    expect($metrics)->toHaveKey($rs2->id_rumah_sakit);

    expect($metrics[$rs1->id_rumah_sakit]['distance'])->toBe(1.2);
    expect($metrics[$rs1->id_rumah_sakit]['duration'])->toBe(3);
    expect($metrics[$rs1->id_rumah_sakit]['is_road_distance'])->toBeTrue();

    expect($metrics[$rs2->id_rumah_sakit]['distance'])->toBe(2.5);
    expect($metrics[$rs2->id_rumah_sakit]['duration'])->toBe(7);
    expect($metrics[$rs2->id_rumah_sakit]['is_road_distance'])->toBeTrue();
});

it('falls back to Haversine calculation when OSRM API fails', function () {
    $rs = RumahSakit::factory()->create([
        'latitude' => 3.5870,
        'longitude' => 98.6437,
    ]);

    Http::fake([
        '*/table/v1/driving/*' => Http::response(null, 500),
    ]);

    $service = new OsrmService;
    $metrics = $service->getDistancesAndDurations(3.5820, 98.6490, [$rs]);

    expect($metrics)->toHaveKey($rs->id_rumah_sakit);
    expect($metrics[$rs->id_rumah_sakit]['distance'])->toBeGreaterThan(0);
    expect($metrics[$rs->id_rumah_sakit]['duration'])->toBeGreaterThan(0);
    expect($metrics[$rs->id_rumah_sakit]['is_road_distance'])->toBeFalse();
});

it('integrates OsrmService with AStarService to rank by road distance', function () {
    $rs1 = RumahSakit::factory()->create([
        'nama_rumah_sakit' => 'RS Dekat Jalan',
        'latitude' => 3.5870,
        'longitude' => 98.6437,
    ]);

    $rs2 = RumahSakit::factory()->create([
        'nama_rumah_sakit' => 'RS Jauh Jalan',
        'latitude' => 3.5985,
        'longitude' => 98.6610,
    ]);

    Http::fake([
        '*/table/v1/driving/*' => Http::response([
            'code' => 'Ok',
            'distances' => [
                [0, 1100, 3200],
            ],
            'durations' => [
                [0, 150, 480],
            ],
        ], 200),
    ]);

    $astar = app(AStarService::class);
    $result = $astar->findBestHospital(3.5820, 98.6490, collect([$rs1, $rs2]));

    expect($result->bestHospital->id_rumah_sakit)->toBe($rs1->id_rumah_sakit);
    expect($result->totalDistance)->toBe(1.1);
    expect($result->estimatedTime)->toBe(3);
    expect($result->estimatedCost)->toBe(5500.0);
    expect($result->allRanked[0]['hospital']->id_rumah_sakit)->toBe($rs1->id_rumah_sakit);
    expect($result->allRanked[1]['hospital']->id_rumah_sakit)->toBe($rs2->id_rumah_sakit);
});
