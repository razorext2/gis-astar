<?php

use App\Livewire\Handler\PetaRute\Index;
use App\Models\DetailRujukan;
use App\Models\Pasien;
use App\Models\Rujukan;
use App\Models\RumahSakit;
use App\Models\Rute;
use App\Models\User;
use Livewire\Livewire;

it('renders the peta rute page successfully for authenticated users', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test(Index::class)
        ->assertStatus(200)
        ->assertSee('Pilih Pasien')
        ->assertSee('Tujuan Rujukan');
});

it('loads matching referral and auto-populates fields when a referral is selected', function () {
    $user = User::factory()->create();
    $pasien = Pasien::factory()->create(['nama' => 'Budi Santoso']);
    $rs = RumahSakit::factory()->create(['nama_rumah_sakit' => 'Rumah Sakit Utama', 'layanan_operasi' => ['Katarak']]);

    $rujukan = Rujukan::create([
        'no_rujukan' => Rujukan::generateNoRujukan(),
        'id_pasien' => $pasien->id_pasien,
        'id_rumah_sakit' => $rs->id_rumah_sakit,
        'id_user' => $user->id,
        'tanggal_rujukan' => now(),
        'status' => 'pending',
    ]);

    // Rute dan DetailRujukan tidak memiliki factory — dibuat langsung sesuai kebutuhan pengujian
    $rute = Rute::create([
        'nama_rute' => 'Test Route',
        'jarak_total' => 5.0,
        'waktu_total' => 600,
        'algoritma' => 'A*',
    ]);

    DetailRujukan::create([
        'id_rujukan' => $rujukan->id_rujukan,
        'id_rute' => $rute->id_rute,
        'jarak' => 5.0,
        'waktu_tempuh' => 600,
        'estimasi_biaya' => 20000,
        'metode' => 'Rute Terpendek',
    ]);

    $this->actingAs($user);

    Livewire::test(Index::class)
        ->set('rujukanId', $rujukan->id_rujukan)
        ->assertSet('pasienId', $pasien->id_pasien)
        ->assertSet('rsId', $rs->id_rumah_sakit)
        ->assertSet('metode', 'Rute Terpendek')
        ->assertSet('selectedPasien.id_pasien', $pasien->id_pasien);
});

it('dispatches a warning when search is triggered without selecting a referral', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test(Index::class)
        ->call('search')
        ->assertDispatched('swal', fn (string $name, array $params) => ($params['icon'] ?? null) === 'warning'
        );
});
