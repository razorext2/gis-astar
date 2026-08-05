<?php

use App\Models\RumahSakit;
use App\Services\HospitalScoringService;

it('filters candidates by layanan and radius', function () {
    $service = new HospitalScoringService;

    // RS 1: Ada layanan ICU, dekat
    $rs1 = RumahSakit::factory()->create([
        'nama_rumah_sakit' => 'RS ICU Dekat',
        'latitude' => -6.1800,
        'longitude' => 106.8200,
        'layanan_operasi' => ['ICU', 'IGD'],
    ]);

    // RS 2: Tidak ada layanan ICU, dekat
    $rs2 = RumahSakit::factory()->create([
        'nama_rumah_sakit' => 'RS Tanpa ICU Dekat',
        'latitude' => -6.1850,
        'longitude' => 106.8250,
        'layanan_operasi' => ['IGD', 'Bedah'],
    ]);

    // RS 3: Ada layanan ICU, sangat jauh (di luar 50km)
    $rs3 = RumahSakit::factory()->create([
        'nama_rumah_sakit' => 'RS ICU Jauh',
        'latitude' => -7.0000,
        'longitude' => 108.0000,
        'layanan_operasi' => ['ICU'],
    ]);

    $pasienLat = -6.1754;
    $pasienLng = 106.8272;

    // Ambil kandidat dengan layanan ICU, radius 50km
    $candidates = $service->getCandidates($pasienLat, $pasienLng, 'ICU', 50);

    // Harus hanya mengembalikan RS 1
    expect($candidates)->toHaveCount(1);
    expect($candidates->first()->id_rumah_sakit)->toBe($rs1->id_rumah_sakit);
});

it('lists all available layanan from all hospitals', function () {
    $service = new HospitalScoringService;

    RumahSakit::query()->delete();

    RumahSakit::factory()->create([
        'layanan_operasi' => ['ICU', 'Bedah'],
    ]);

    RumahSakit::factory()->create([
        'layanan_operasi' => ['ICU', 'Jantung'],
    ]);

    $layanan = $service->getAllAvailableLayanan();

    expect($layanan)->toBeArray();
    expect($layanan)->toContain('ICU');
    expect($layanan)->toContain('Bedah');
    expect($layanan)->toContain('Jantung');
    expect($layanan)->toHaveCount(3);
});
