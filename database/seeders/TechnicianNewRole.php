<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TechnicianNewRole extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'name' => 'Kepala-Teknisi',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('permissions')->insert([
            ['name' => 'all-team', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'team-list', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'team-create', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'team-edit', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'team-delete', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'team-member-add', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'team-member-remove', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
