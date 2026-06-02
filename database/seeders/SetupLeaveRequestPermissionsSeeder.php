<?php

namespace Database\Seeders;

/** Goal: Setup permissions for Leave Request and assign them to roles, Caller: php artisan db:seed --class=SetupLeaveRequestPermissionsSeeder, Deps: Spatie\Permission */

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class SetupLeaveRequestPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan cache permission
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Daftar semua permission baru dengan prefix leave-
        $permissions = [
            'leave-list-own',
            'leave-create',
            'leave-cancel',
            'leave-approval-center',
            'leave-list-all',
            'leave-balance-manage',
            'leave-type-manage',
            'leave-approve-hrd',
            'leave-report-export',
            'leave-approve-management',
        ];

        DB::transaction(function () use ($permissions) {
            // 1. Buat semua permission jika belum ada
            foreach ($permissions as $permissionName) {
                Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => 'web',
                ]);
            }

            // 2. Definisi mapping Role ke Permission
            $roleAssignments = [
                'Employee' => [
                    'leave-list-own',
                    'leave-create',
                    'leave-cancel',
                ],
                'HRD' => [
                    'leave-approval-center',
                    'leave-list-all',
                    'leave-balance-manage',
                    'leave-type-manage',
                    'leave-approve-hrd',
                    'leave-report-export',
                ],
                'Management' => [
                    'leave-approve-management',
                    'leave-report-export',
                ],
            ];

            // 3. Assign permission ke masing-masing role
            foreach ($roleAssignments as $roleName => $perms) {
                // Pastikan role ada, jika tidak ada maka dibuat
                $role = Role::firstOrCreate([
                    'name' => $roleName,
                    'guard_name' => 'web',
                ]);

                // Menggunakan syncPermissions agar role hanya memiliki permission yang didefinisikan (opsional)
                // Atau givePermissionTo untuk sekedar menambahkan
                $role->givePermissionTo($perms);

                $this->command->info("Permissions berhasil di-assign ke role: {$roleName}");
            }
        });

        $this->command->info('Setup Permission Leave Request selesai.');
    }
}
