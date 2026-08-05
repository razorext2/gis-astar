<?php

use App\Livewire\Handler\Pasien\Create;
use App\Livewire\Handler\Pasien\Edit;
use App\Models\Pasien;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    // Buat permission & role
    Permission::firstOrCreate(['name' => 'pasien-list']);
    Permission::firstOrCreate(['name' => 'pasien-create']);
    Permission::firstOrCreate(['name' => 'pasien-edit']);

    $role = Role::firstOrCreate(['name' => 'Dokter']);
    $role->syncPermissions(['pasien-list', 'pasien-create', 'pasien-edit']);

    $this->user = User::factory()->create();
    $this->user->assignRole($role);
});

it('renders index page for authorized users', function () {
    $this->actingAs($this->user);

    $response = $this->get(route('pasien.index'));
    $response->assertStatus(200);
});

it('can create a new pasien via Livewire handler', function () {
    $this->actingAs($this->user);

    Livewire::test(Create::class)
        ->set('nik', '1234567890123456')
        ->set('nama', 'Budi Santoso')
        ->set('jenis_kelamin', 'laki_laki')
        ->set('latitude', -6.1754)
        ->set('longitude', 106.8272)
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('pasien.index'));

    $this->assertDatabaseHas('pasien', [
        'nik' => '1234567890123456',
        'nama' => 'Budi Santoso',
        'jenis_kelamin' => 'laki_laki',
        'latitude' => -6.1754,
        'longitude' => 106.8272,
    ]);
});

it('can edit an existing pasien via Livewire handler', function () {
    $this->actingAs($this->user);

    $pasien = Pasien::factory()->create([
        'nama' => 'Pasien Lama',
        'jenis_kelamin' => 'perempuan',
    ]);

    Livewire::test(Edit::class, ['pasien' => $pasien])
        ->set('nama', 'Pasien Baru')
        ->set('jenis_kelamin', 'laki_laki')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('pasien.index'));

    $this->assertDatabaseHas('pasien', [
        'id_pasien' => $pasien->id_pasien,
        'nama' => 'Pasien Baru',
        'jenis_kelamin' => 'laki_laki',
    ]);
});
