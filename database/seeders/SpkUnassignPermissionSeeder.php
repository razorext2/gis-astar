<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SpkUnassignPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permission = Permission::firstOrCreate([
            'name' => 'spk-no-tagihan-unassign',
            'guard_name' => 'web',
        ]);

        foreach (['Admin', 'Management'] as $roleName) {
            $role = Role::findByName($roleName);

            if ($role && ! $role->hasPermissionTo($permission)) {
                $role->givePermissionTo($permission);
            }
        }
    }
}
