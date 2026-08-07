<?php

use App\Livewire\Handler\Rujukan\Create;
use App\Models\Pasien;
use App\Models\RiwayatRujukan;
use App\Models\Rujukan;
use App\Models\RumahSakit;
use App\Models\User;
use Livewire\Livewire;

it('sets astarResult correctly when searchReferral is called', function () {
    $user = User::factory()->create();
    $pasien = Pasien::factory()->create([
        'latitude' => 3.582,
        'longitude' => 98.649,
    ]);

    // Create a couple of hospitals
    $rs1 = RumahSakit::factory()->create([
        'nama_rumah_sakit' => 'SMEC Medan',
        'latitude' => 3.587,
        'longitude' => 98.6437,
        'layanan_operasi' => ['IGD Mata', 'Katarak'],
    ]);

    $rs2 = RumahSakit::factory()->create([
        'nama_rumah_sakit' => 'Medan Eye Centre',
        'latitude' => 3.595,
        'longitude' => 98.674,
        'layanan_operasi' => ['IGD Mata', 'Katarak'],
    ]);

    $this->actingAs($user);

    $component = Livewire::test(Create::class, ['pasien' => $pasien->id_pasien])
        ->assertSet('pasienId', $pasien->id_pasien);

    // Call searchReferral
    $component->call('searchReferral');

    $astarResult = $component->get('astarResult');

    expect($astarResult)->not->toBeNull();
    expect($astarResult)->toBeArray();
    expect($astarResult)->toHaveKey('all_ranked');
    expect($astarResult['all_ranked'])->toHaveCount(2);

    // Check if the closest is first (SMEC Medan)
    expect($astarResult['all_ranked'][0]['hospital']['nama'])->toBe('SMEC Medan');
    expect($astarResult['all_ranked'][1]['hospital']['nama'])->toBe('Medan Eye Centre');
});

it('filters astarResult by target hospital when selected', function () {
    $user = User::factory()->create();
    $pasien = Pasien::factory()->create([
        'latitude' => 3.582,
        'longitude' => 98.649,
    ]);

    $rs1 = RumahSakit::factory()->create([
        'nama_rumah_sakit' => 'SMEC Medan',
        'latitude' => 3.587,
        'longitude' => 98.6437,
        'layanan_operasi' => ['IGD Mata', 'Katarak'],
    ]);

    $rs2 = RumahSakit::factory()->create([
        'nama_rumah_sakit' => 'Medan Eye Centre',
        'latitude' => 3.595,
        'longitude' => 98.674,
        'layanan_operasi' => ['IGD Mata', 'Katarak'],
    ]);

    $this->actingAs($user);

    $component = Livewire::test(Create::class, ['pasien' => $pasien->id_pasien])
        ->set('rumahSakitTarget', (string) $rs2->id_rumah_sakit);

    $component->call('searchReferral');

    $astarResult = $component->get('astarResult');

    expect($astarResult)->not->toBeNull();
    expect($astarResult['all_ranked'])->toHaveCount(1);
    expect($astarResult['all_ranked'][0]['hospital']['nama'])->toBe('Medan Eye Centre');
});

it('simpanRiwayat creates a RiwayatRujukan record and redirects to show page', function () {
    $user = User::factory()->create();
    $pasien = Pasien::factory()->create([
        'latitude' => 3.582,
        'longitude' => 98.649,
    ]);

    $rs1 = RumahSakit::factory()->create([
        'nama_rumah_sakit' => 'SMEC Medan',
        'latitude' => 3.587,
        'longitude' => 98.6437,
        'layanan_operasi' => ['IGD Mata', 'Katarak'],
    ]);

    $rs2 = RumahSakit::factory()->create([
        'nama_rumah_sakit' => 'Medan Eye Centre',
        'latitude' => 3.595,
        'longitude' => 98.674,
        'layanan_operasi' => ['IGD Mata', 'Katarak'],
    ]);

    $this->actingAs($user);

    $component = Livewire::test(Create::class, ['pasien' => $pasien->id_pasien]);
    $component->call('searchReferral');

    $rujukanId = $component->get('rujukanId');
    expect($rujukanId)->not->toBeNull();

    // User picks rs2 (different from best A* result rs1)
    $component->call('simpanRiwayat', $rs2->id_rumah_sakit);

    // A RiwayatRujukan record should exist
    $riwayat = RiwayatRujukan::where('id_rujukan', $rujukanId)->first();
    expect($riwayat)->not->toBeNull();
    expect($riwayat->id_rujukan)->toBe($rujukanId);

    // The rujukan's target RS should have been updated to rs2
    $rujukan = Rujukan::find($rujukanId);
    expect($rujukan->id_rumah_sakit)->toBe($rs2->id_rumah_sakit);

    // Should redirect to show page
    $component->assertRedirect(route('rujukan.show', $rujukanId));
});
