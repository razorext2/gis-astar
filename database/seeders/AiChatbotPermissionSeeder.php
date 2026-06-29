<?php

/** Goal: Create ai-chatbot permission and assign to Admin, Management, and HRD roles, Caller: DatabaseSeeder or manual seeding, Deps: Spatie Permission */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AiChatbotPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = Permission::firstOrCreate([
            'name' => 'ai-chatbot',
            'guard_name' => 'web',
        ]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = Role::query()->whereIn('name', ['Admin', 'Management', 'HRD'])->get();

        foreach ($roles as $role) {
            if (! $role->hasPermissionTo('ai-chatbot')) {
                $role->givePermissionTo($permission);
            }
        }
    }
}
