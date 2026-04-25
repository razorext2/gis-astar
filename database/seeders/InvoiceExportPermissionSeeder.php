<?php

/** Goal: Seeder permission export invoice, Caller: artisan db:seed, Deps: Spatie Permission */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class InvoiceExportPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'invoice-export-all',
            'invoice-export-cust',
            'invoice-export-medan',
            'invoice-export-pku',
            'invoice-export-jkt',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign semua permission export ke Admin
        $admin = Role::findByName('Admin');
        $admin->givePermissionTo($permissions);
    }
}
