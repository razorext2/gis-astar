<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class GiveLaporanHarianPermissionsToAdminManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'laporan-harian-list',
            'laporan-harian-spk-list',
            'assign-laporan-harian',
            'unassign-laporan-harian',
            'assign-laporan-harian-spk',
            'unassign-laporan-harian-spk',
            'laporan-harian-create',
            'laporan-harian-edit',
            'laporan-harian-delete',
            'laporan-harian-validate',
        ];

        $roles = Role::whereIn('name', ['Admin', 'Management'])->get();

        foreach ($roles as $role) {
            $role->givePermissionTo($permissions);
        }
    }
}
