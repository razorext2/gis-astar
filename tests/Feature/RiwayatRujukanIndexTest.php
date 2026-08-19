<?php

use App\Livewire\Handler\RiwayatRujukan\Index;
use App\Models\Pasien;
use App\Models\Rujukan;
use App\Models\RumahSakit;
use App\Models\User;
use Livewire\Livewire;

it('renders the riwayat rujukan page with stat cards and table', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test(Index::class)
        ->assertStatus(200)
        ->assertSee('Total Rujukan')
        ->assertSee('Selesai')
        ->assertSee('Proses')
        ->assertSee('Dibatalkan');
});

it('filters rujukan by search keyword', function () {
    $user = User::factory()->create();
    $pasien = Pasien::factory()->create(['nama' => 'Budi Santoso']);
    $rs = RumahSakit::factory()->create(['layanan_operasi' => ['Katarak']]);

    Rujukan::create([
        'no_rujukan' => Rujukan::generateNoRujukan(),
        'id_pasien' => $pasien->id_pasien,
        'id_rumah_sakit' => $rs->id_rumah_sakit,
        'id_user' => $user->id,
        'tanggal_rujukan' => now(),
        'status' => 'pending',
    ]);

    $this->actingAs($user);

    Livewire::test(Index::class)
        ->set('search', 'Budi Santoso')
        ->assertSee('Budi Santoso');
});

it('filters rujukan by status', function () {
    $user = User::factory()->create();
    $pasien = Pasien::factory()->create();
    $rs = RumahSakit::factory()->create(['layanan_operasi' => ['Katarak']]);

    Rujukan::create([
        'no_rujukan' => Rujukan::generateNoRujukan(),
        'id_pasien' => $pasien->id_pasien,
        'id_rumah_sakit' => $rs->id_rumah_sakit,
        'id_user' => $user->id,
        'tanggal_rujukan' => now(),
        'status' => 'selesai',
    ]);

    $this->actingAs($user);

    Livewire::test(Index::class)
        ->set('status', 'selesai')
        ->assertSee('Selesai');
});

it('resets filters when resetFilter is called', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test(Index::class)
        ->set('search', 'foo')
        ->set('status', 'selesai')
        ->call('resetFilter')
        ->assertSet('search', '')
        ->assertSet('status', '');
});
