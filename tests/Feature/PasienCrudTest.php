<?php

use App\Livewire\Handler\Pasien\Create;
use App\Livewire\Handler\Pasien\Edit;
use App\Livewire\PowergridTables\PasienTable;
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
    Permission::firstOrCreate(['name' => 'pasien-delete']);

    $role = Role::firstOrCreate(['name' => 'Dokter']);
    $role->syncPermissions(['pasien-list', 'pasien-create', 'pasien-edit', 'pasien-delete']);

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

it('can soft delete a pasien via Edit handler', function () {
    $this->actingAs($this->user);

    $pasien = Pasien::factory()->create([
        'nama' => 'Pasien Mau Dihapus',
    ]);

    Livewire::test(Edit::class, ['pasien' => $pasien])
        ->call('delete')
        ->assertDispatched('swal')
        ->assertRedirect(route('pasien.index'));

    $this->assertSoftDeleted('pasien', [
        'id_pasien' => $pasien->id_pasien,
    ]);
});

it('can soft delete a pasien via PasienTable', function () {
    $this->actingAs($this->user);

    $pasien = Pasien::factory()->create([
        'nama' => 'Pasien Tabel Delete',
    ]);

    Livewire::test(PasienTable::class)
        ->call('delete', $pasien->id_pasien)
        ->assertDispatched('swal');

    $this->assertSoftDeleted('pasien', [
        'id_pasien' => $pasien->id_pasien,
    ]);
});

it('can restore a soft deleted pasien via PasienTable', function () {
    $this->actingAs($this->user);

    $pasien = Pasien::factory()->create([
        'nama' => 'Pasien Terhapus',
    ]);
    $pasien->delete();

    $this->assertSoftDeleted('pasien', [
        'id_pasien' => $pasien->id_pasien,
    ]);

    Livewire::test(PasienTable::class)
        ->call('restore', $pasien->id_pasien)
        ->assertDispatched('swal');

    $this->assertNotSoftDeleted('pasien', [
        'id_pasien' => $pasien->id_pasien,
    ]);
});
