<?php

use App\Livewire\Handler\PetaRute\Index;
use App\Models\Pasien;
use App\Models\Rujukan;
use App\Models\RumahSakit;
use App\Models\User;
use Livewire\Livewire;

it('renders the peta rute page successfully for authenticated users', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test(Index::class)
        ->assertStatus(200)
        ->assertSee('Lokasi Pasien')
        ->assertSee('Tujuan Rujukan');
});

it('loads matching hospitals when a patient is selected', function () {
    $user = User::factory()->create();
    $pasien = Pasien::factory()->create(['nama' => 'Budi Santoso']);
    $rs = RumahSakit::factory()->create(['nama_rumah_sakit' => 'Rumah Sakit Utama', 'layanan_operasi' => ['Katarak']]);

    Rujukan::create([
        'no_rujukan'      => Rujukan::generateNoRujukan(),
        'id_pasien'       => $pasien->id_pasien,
        'id_rumah_sakit'  => $rs->id_rumah_sakit,
        'id_user'         => $user->id,
        'tanggal_rujukan' => now(),
        'status'          => 'pending',
    ]);

    $this->actingAs($user);

    Livewire::test(Index::class)
        ->set('pasienId', $pasien->id_pasien)
        ->assertSet('selectedPasien.id_pasien', $pasien->id_pasien)
        ->assertCount('rsList', 1)
        ->assertSee('Rumah Sakit Utama');
});
