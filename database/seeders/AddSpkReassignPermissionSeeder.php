<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AddSpkReassignPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'spk-reassign',
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
                    'spk-reassign',
                ],
                'Produksi' => [
                    'spk-reassign',
                ],
                'Management' => [
                    'spk-reassign',
                ],
                'Marketing' => [
                    'spk-reassign',
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

        $this->command->info('Setup Permission SPK Reassign selesai.');
    }
}
