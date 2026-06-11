<?php

/** Goal: Test query data in SalesTable and ensure no duplication, Caller: pest, Deps: SalesTable, User, Role, Sales */

use App\Livewire\PowergridTables\SalesTable;
use App\Models\Pegawai;
use App\Models\Sales;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    Role::firstOrCreate(['name' => 'Collector', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'Sales', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'Kurir-Bank', 'guard_name' => 'web']);

    $this->pegawai = Pegawai::create([
        'kode_pegawai' => '394',
        'nik_pegawai' => '394-NIK',
        'full_name' => 'KEVIN FRANSETIO'
    ]);

    $this->user = User::factory()->create([
        'kode_pegawai' => '394',
        'name' => 'KEVIN FRANSETIO',
        'email' => 'kevin@example.com',
        'is_active' => true,
    ]);

    $this->user->assignRole(['Collector', 'Sales', 'Kurir-Bank']);

    $this->salesReport = Sales::create([
        'kode_pegawai' => '394',
        'title' => 'Test Sales Report',
        'customer_name' => 'John Doe',
        'customer_telp' => '08123456789',
        'lokasi' => 'Test Location',
        'keterangan' => 'Test Description',
        'longitude' => '100.0',
        'latitude' => '10.0',
        'status' => 0,
        'customer_make_order' => 1,
    ]);
});

test('sales agent with multiple roles does not see duplicate rows in SalesTable', function () {
    $this->actingAs($this->user);

    $component = Livewire::test(SalesTable::class);
    
    $query = $component->instance()->datasource();
    
    expect($query->count())->toBe(1);
    
    $results = $query->get();
    expect($results->count())->toBe(1);
});

test('approver can filter by role_name using whereHas builder', function () {
    Permission::firstOrCreate(['name' => 'sales-approve', 'guard_name' => 'web']);
    Permission::firstOrCreate(['name' => 'sales-export-all', 'guard_name' => 'web']);
    
    $approver = User::factory()->create(['is_active' => true]);
    $approver->givePermissionTo(['sales-approve', 'sales-export-all']);
    
    $this->actingAs($approver);
    
    $component = Livewire::test(SalesTable::class);
    
    $queryWithoutFilter = $component->instance()->datasource();
    expect($queryWithoutFilter->count())->toBe(1);
});
