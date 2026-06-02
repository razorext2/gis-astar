<?php

/** Goal: Add permissions to replace hardcoded role checks, Caller: migration, Deps: Spatie Permission */

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    private const NEW_PERMISSIONS = [
        'spk-edit-all' => ['Admin', 'Management'],
        'vt-view-all' => ['Admin', 'Management'],
        'spk-view-own-only' => ['Marketing', 'Marketing-IDY', 'Marketing-JKT', 'Marketing-PKU'],
    ];

    public function up(): void
    {
        foreach (self::NEW_PERMISSIONS as $permissionName => $roleNames) {
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

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }

    public function down(): void
    {
        foreach (array_keys(self::NEW_PERMISSIONS) as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            if ($permission) {
                $permission->delete();
            }
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
};
