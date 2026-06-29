<?php

/** Goal: Add ai-chatbot permission and assign it to key roles, Caller: Migration command, Deps: Spatie Permission */

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    private const PERMISSION_NAME = 'ai-chatbot';
    private const ROLES = ['Admin', 'Management', 'HRD'];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $permission = Permission::firstOrCreate([
            'name' => self::PERMISSION_NAME,
            'guard_name' => 'web',
        ]);

        foreach (self::ROLES as $roleName) {
            $role = Role::query()->where('name', $roleName)->first();
            if ($role && ! $role->hasPermissionTo(self::PERMISSION_NAME)) {
                $role->givePermissionTo($permission);
            }
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::query()->where('name', self::PERMISSION_NAME)->delete();

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
};
