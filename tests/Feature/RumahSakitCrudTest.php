<?php

use App\Livewire\Handler\RumahSakit\Create;
use App\Livewire\Handler\RumahSakit\Edit;
use App\Livewire\PowergridTables\RumahSakitTable;
use App\Models\RumahSakit;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Permission::firstOrCreate(['name' => 'rs-list']);
    Permission::firstOrCreate(['name' => 'rs-create']);
    Permission::firstOrCreate(['name' => 'rs-edit']);
    Permission::firstOrCreate(['name' => 'rs-delete']);

    $role = Role::firstOrCreate(['name' => 'Super Admin']);
    $role->syncPermissions(['rs-list', 'rs-create', 'rs-edit', 'rs-delete']);

    $this->user = User::factory()->create();
    $this->user->assignRole($role);
});

it('renders rs index page for authorized users', function () {
    $this->actingAs($this->user);

    $response = $this->get(route('rs.index'));
    $response->assertStatus(200);
});

it('can create a new rs via Livewire handler', function () {
    $this->actingAs($this->user);

    Livewire::test(Create::class)
        ->set('nama_rumah_sakit', 'RSU Daerah Baru')
        ->set('alamat', 'Jl. Baru No. 10')
        ->set('latitude', -6.2000)
        ->set('longitude', 106.8000)
        ->set('layanan_operasi', ['IGD', 'ICU'])
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('rs.index'));

    $rs = RumahSakit::where('nama_rumah_sakit', 'RSU Daerah Baru')->first();
    expect($rs)->not->toBeNull();
    expect($rs->layanan_list)->toContain('IGD');
    expect($rs->layanan_list)->toContain('ICU');
});

it('can edit an existing rs via Livewire handler', function () {
    $this->actingAs($this->user);

    $rs = RumahSakit::factory()->create([
        'nama_rumah_sakit' => 'RS Lama',
        'layanan_operasi' => json_encode(['ICU']),
    ]);

    Livewire::test(Edit::class, ['rumahSakit' => $rs])
        ->set('nama_rumah_sakit', 'RS Ter-update')
        ->set('layanan_operasi', ['ICU', 'Bedah'])
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('rs.index'));

    $rs->refresh();
    expect($rs->nama_rumah_sakit)->toBe('RS Ter-update');
    expect($rs->layanan_list)->toContain('Bedah');
});

it('can soft delete a rs via Edit handler', function () {
    $this->actingAs($this->user);

    $rs = RumahSakit::factory()->create([
        'nama_rumah_sakit' => 'RS Mau Dihapus',
    ]);

    Livewire::test(Edit::class, ['rumahSakit' => $rs])
        ->call('delete')
        ->assertDispatched('swal')
        ->assertRedirect(route('rs.index'));

    $this->assertSoftDeleted('rumah_sakit_rujukan', [
        'id_rumah_sakit' => $rs->id_rumah_sakit,
    ]);
});

it('can soft delete a rs via RumahSakitTable', function () {
    $this->actingAs($this->user);

    $rs = RumahSakit::factory()->create([
        'nama_rumah_sakit' => 'RS Tabel Delete',
    ]);

    Livewire::test(RumahSakitTable::class)
        ->call('delete', $rs->id_rumah_sakit)
        ->assertDispatched('swal');

    $this->assertSoftDeleted('rumah_sakit_rujukan', [
        'id_rumah_sakit' => $rs->id_rumah_sakit,
    ]);
});

it('can restore a soft deleted rs via RumahSakitTable', function () {
    $this->actingAs($this->user);

    $rs = RumahSakit::factory()->create([
        'nama_rumah_sakit' => 'RS Terhapus',
    ]);
    $rs->delete();

    $this->assertSoftDeleted('rumah_sakit_rujukan', [
        'id_rumah_sakit' => $rs->id_rumah_sakit,
    ]);

    Livewire::test(RumahSakitTable::class)
        ->call('restore', $rs->id_rumah_sakit)
        ->assertDispatched('swal');

    $this->assertNotSoftDeleted('rumah_sakit_rujukan', [
        'id_rumah_sakit' => $rs->id_rumah_sakit,
    ]);
});
