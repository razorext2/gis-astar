<?php

/** Goal: Seed permissions for hardcode removal refactor, Caller: artisan db:seed, Deps: Spatie Permission */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class HardcodeRemovalPermissionSeeder extends Seeder
{
    /**
     * @var array<string, list<string>>
     */
    private const PERMISSION_ROLE_MAP = [
        'spk-edit-all' => ['Admin', 'Management'],
        'vt-view-all' => ['Admin', 'Management'],
        'spk-view-own-only' => ['Marketing', 'Marketing-IDY', 'Marketing-JKT', 'Marketing-PKU'],
    ];

    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (self::PERMISSION_ROLE_MAP as $permissionName => $roleNames) {
            $permission = Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web',
            ]);

            foreach ($roleNames as $roleName) {
                $role = Role::where('name', $roleName)->first();
                if ($role && ! $role->hasPermissionTo($permissionName)) {
                    $role->givePermissionTo($permission);
                }
            }
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info('Hardcode removal permissions seeded successfully.');
    }
}
