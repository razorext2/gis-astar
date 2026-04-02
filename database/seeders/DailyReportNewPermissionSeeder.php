<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DailyReportNewPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // buat permission
        DB::table('permissions')->insert([
            [
                'name' => 'laporan-harian-extend',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // assign permission ke role
        $roles = Role::whereIn('name', ['Admin', 'Management', 'Teknisi', 'Mekanik', 'Service'])
            ->get();

        foreach ($roles as $role) {
            $role->givePermissionTo('laporan-harian-extend');
        }
    }
}
