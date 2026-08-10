<?php

use App\Livewire\Handler\Rujukan\Create;
use App\Models\Pasien;
use App\Models\RiwayatRujukan;
use App\Models\Rujukan;
use App\Models\RumahSakit;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->pasien = Pasien::factory()->create([
        'latitude' => 3.582,
        'longitude' => 98.649,
    ]);

    $this->rs1 = RumahSakit::factory()->create([
        'nama_rumah_sakit' => 'SMEC Medan',
        'latitude' => 3.587,
        'longitude' => 98.6437,
        'layanan_operasi' => ['IGD Mata', 'Katarak'],
    ]);

    $this->rs2 = RumahSakit::factory()->create([
        'nama_rumah_sakit' => 'Medan Eye Centre',
        'latitude' => 3.595,
        'longitude' => 98.674,
        'layanan_operasi' => ['IGD Mata', 'Katarak'],
    ]);

    $this->actingAs($this->user);
});

it('sets astarResult correctly when searchReferral is called', function () {
    $component = Livewire::test(Create::class, ['pasien' => $this->pasien->id_pasien])
        ->assertSet('pasienId', $this->pasien->id_pasien);

    $component->call('searchReferral');

    $astarResult = $component->get('astarResult');

    expect($astarResult)->not->toBeNull();
    expect($astarResult)->toBeArray();
    expect($astarResult)->toHaveKey('all_ranked');
    expect($astarResult['all_ranked'])->toHaveCount(2);

    // Check if the closest is first (SMEC Medan)
    expect($astarResult['all_ranked'][0]['hospital']['nama_rumah_sakit'])->toBe('SMEC Medan');
    expect($astarResult['all_ranked'][1]['hospital']['nama_rumah_sakit'])->toBe('Medan Eye Centre');
});

it('filters astarResult by target hospital when selected', function () {
    $component = Livewire::test(Create::class, ['pasien' => $this->pasien->id_pasien])
        ->set('rumahSakitTarget', (string) $this->rs2->id_rumah_sakit);

    $component->call('searchReferral');

    $astarResult = $component->get('astarResult');

    expect($astarResult)->not->toBeNull();
    expect($astarResult['all_ranked'])->toHaveCount(1);
    expect($astarResult['all_ranked'][0]['hospital']['nama_rumah_sakit'])->toBe('Medan Eye Centre');
});

it('simpanRiwayat creates a RiwayatRujukan record and dispatches swal', function () {
    $component = Livewire::test(Create::class, ['pasien' => $this->pasien->id_pasien]);
    $component->call('searchReferral');

    $rujukanId = $component->get('rujukanId');
    expect($rujukanId)->not->toBeNull();

    // User picks rs2 (different from best A* result rs1)
    $component->call('simpanRiwayat', $this->rs2->id_rumah_sakit);

    // A RiwayatRujukan record should exist
    $riwayat = RiwayatRujukan::where('id_rujukan', $rujukanId)->first();
    expect($riwayat)->not->toBeNull();
    expect($riwayat->id_rujukan)->toBe($rujukanId);

    // The rujukan's target RS should have been updated to rs2
    $rujukan = Rujukan::find($rujukanId);
    expect($rujukan->id_rumah_sakit)->toBe($this->rs2->id_rumah_sakit);

    // Should dispatch swal with redirect payload
    $component->assertDispatched('swal', function ($name, $params) use ($rujukanId) {
        return $params['title'] === 'Berhasil' && $params['redirect']['url'] === route('rujukan.show', $rujukanId);
    });
});
