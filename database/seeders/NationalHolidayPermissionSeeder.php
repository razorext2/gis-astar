<?php

namespace Database\Seeders;

/** Goal: Setup permissions for National Holiday management. Caller: php artisan db:seed --class=NationalHolidayPermissionSeeder, Deps: Spatie\Permission */

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class NationalHolidayPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'holiday-list',
            'holiday-create',
            'holiday-delete',
        ];

        DB::transaction(function () use ($permissions) {
            foreach ($permissions as $permissionName) {
                Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => 'web',
                ]);
            }

            $roleAssignments = [
                'Admin' => [
                    'holiday-list',
                    'holiday-create',
                    'holiday-delete',
                ],
                'HRD' => [
                    'holiday-list',
                    'holiday-create',
                    'holiday-delete',
                ],
                'Management' => [
                    'holiday-list',
                ],
            ];

            foreach ($roleAssignments as $roleName => $perms) {
                $role = Role::where('name', $roleName)->first();
                if ($role) {
                    $role->givePermissionTo($perms);
                    $this->command->info("Permissions berhasil di-assign ke role: {$roleName}");
                }
            }
        });

        $this->command->info('Setup Permission National Holiday selesai.');
    }
}
