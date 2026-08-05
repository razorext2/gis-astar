<?php

use App\Exceptions\BusinessException;
use App\Models\DetailRujukan;
use App\Models\Pasien;
use App\Models\Rujukan;
use App\Models\RumahSakit;
use App\Models\Rute;
use App\Models\TitikRute;
use App\Models\User;
use App\Services\ReferralService;

it('fails processing referral if patient has no coordinates', function () {
    $user = User::factory()->create();
    $pasien = Pasien::factory()->withoutCoordinates()->create();

    $service = app(ReferralService::class);

    expect(fn () => $service->processReferral($pasien, 'ICU', $user))
        ->toThrow(BusinessException::class, 'Data koordinat pasien');
});

it('fails processing referral if no candidate hospitals found within radius', function () {
    $user = User::factory()->create();
    $pasien = Pasien::factory()->create([
        'latitude' => -6.1754,
        'longitude' => 106.8272,
    ]);

    // Tidak ada RS sama sekali, atau semua RS tidak memiliki layanan 'ICU'
    RumahSakit::query()->delete();

    $service = app(ReferralService::class);

    expect(fn () => $service->processReferral($pasien, 'ICU', $user, 10))
        ->toThrow(BusinessException::class, 'Tidak ditemukan rumah sakit dengan layanan');
});

it('successfully processes automatic referral and persists data', function () {
    $user = User::factory()->create();
    $pasien = Pasien::factory()->create([
        'latitude' => -6.1754,
        'longitude' => 106.8272,
    ]);

    $rs = RumahSakit::factory()->create([
        'latitude' => -6.1800,
        'longitude' => 106.8200,
        'layanan_operasi' => ['ICU'],
    ]);

    $service = app(ReferralService::class);

    $result = $service->processReferral($pasien, 'ICU', $user, 50);

    // Cek hasil DTO
    expect($result->rujukan)->toBeInstanceOf(Rujukan::class);
    expect($result->astarResult->bestHospital->id_rumah_sakit)->toBe($rs->id_rumah_sakit);

    // Cek database rujukan
    $this->assertDatabaseHas('rujukan', [
        'id_rujukan' => $result->rujukan->id_rujukan,
        'id_pasien' => $pasien->id_pasien,
        'id_rumah_sakit' => $rs->id_rumah_sakit,
        'status' => 'pending',
    ]);

    // Cek database detail_rujukan
    $this->assertDatabaseHas('detail_rujukan', [
        'id_rujukan' => $result->rujukan->id_rujukan,
        'metode' => 'otomatis',
    ]);

    // Cek database rute
    $detail = DetailRujukan::where('id_rujukan', $result->rujukan->id_rujukan)->first();
    expect($detail->rute)->toBeInstanceOf(Rute::class);

    // Cek database titik_rute (waypoints: minimal ada titik awal dan titik tujuan)
    $waypoints = TitikRute::where('id_rute', $detail->id_rute)->orderBy('urutan')->get();
    expect($waypoints)->toHaveCount(2);
    expect($waypoints[0]->tipe->value)->toBe('awal');
    expect($waypoints[1]->tipe->value)->toBe('tujuan');
});

it('logs status change in riwayat_rujukan when status changes', function () {
    $user = User::factory()->create();
    $pasien = Pasien::factory()->create();
    $rs = RumahSakit::factory()->create(['layanan_operasi' => ['ICU']]);

    // Authenticate user to capture in Observer
    $this->actingAs($user);

    // Buat rujukan
    $rujukan = Rujukan::create([
        'no_rujukan' => Rujukan::generateNoRujukan(),
        'id_pasien' => $pasien->id_pasien,
        'id_rumah_sakit' => $rs->id_rumah_sakit,
        'id_user' => $user->id,
        'tanggal_rujukan' => now(),
        'status' => 'pending',
    ]);

    // Ubah status
    $rujukan->update(['status' => 'disetujui']);

    // Cek riwayat_rujukan harus terisi
    $this->assertDatabaseHas('riwayat_rujukan', [
        'id_rujukan' => $rujukan->id_rujukan,
        'status_lama' => 'pending',
        'status_baru' => 'disetujui',
        'diubah_oleh' => $user->id,
    ]);
});
