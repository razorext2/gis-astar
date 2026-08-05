<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // System
            'users-list', 'users-create', 'users-edit', 'users-delete',
            'roles-list', 'roles-create', 'roles-edit', 'roles-delete',
            'permissions-list', 'permissions-create', 'permissions-edit', 'permissions-delete',
            'log-list', 'settings-manage',
            // Pasien
            'pasien-list', 'pasien-create', 'pasien-edit', 'pasien-delete',
            // Rumah Sakit
            'rs-list', 'rs-create', 'rs-edit', 'rs-delete',
            // Rujukan
            'rujukan-list', 'rujukan-create', 'rujukan-view', 'rujukan-update-status',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Super Admin — semua permission
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin->syncPermissions(Permission::all());

        // Dokter — manajemen pasien + buat rujukan
        $dokter = Role::firstOrCreate(['name' => 'dokter']);
        $dokter->syncPermissions([
            'pasien-list', 'pasien-create', 'pasien-edit',
            'rs-list',
            'rujukan-list', 'rujukan-create', 'rujukan-view', 'rujukan-update-status',
        ]);

        // Operator — lihat & update status
        $operator = Role::firstOrCreate(['name' => 'operator']);
        $operator->syncPermissions([
            'pasien-list', 'rs-list',
            'rujukan-list', 'rujukan-view', 'rujukan-update-status',
        ]);

        // Admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@gis-astar.biz.id'],
            ['name' => 'Admin GIS A*', 'password' => Hash::make('admin123'), 'is_active' => true]
        );
        $admin->assignRole($superAdmin);

        // Dokter user (untuk testing)
        $dokterUser = User::updateOrCreate(
            ['email' => 'dokter@gis-astar.biz.id'],
            ['name' => 'Dr. Budi Santoso', 'password' => Hash::make('dokter123'), 'is_active' => true]
        );
        $dokterUser->assignRole($dokter);

        $this->call([
            SettingSeeder::class,
            RumahSakitSeeder::class,
            PasienSeeder::class,
        ]);
    }
}
