<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AttendanceNewPermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            ['name' => 'attendance-approve', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $roles = Role::whereIn('name', ['Admin', 'HRD', 'Management'])->get();

        foreach ($roles as $role) {
            $role->givePermissionTo('attendance-approve');
        }
    }
}
