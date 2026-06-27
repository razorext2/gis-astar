<?php

/** Goal: Setup permissions for Attendance Inquiry and assign them to roles, Caller: php artisan db:seed --class=AttendanceInquiryPermissionSeeder, Deps: Spatie\Permission */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AttendanceInquiryPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan cache permission
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Daftar semua permission baru
        $permissions = [
            'attendance-inquiry-list-own',
            'attendance-inquiry-create',
            'attendance-inquiry-approval-center',
            'attendance-inquiry-approve-hrd',
        ];

        DB::transaction(function () use ($permissions) {
            // 1. Buat semua permission jika belum ada
            foreach ($permissions as $permissionName) {
                Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => 'web',
                ]);
            }

            // 2. Definisi mapping Role ke Permission
            $roleAssignments = [
                'Employee' => [
                    'attendance-inquiry-list-own',
                    'attendance-inquiry-create',
                ],
                'HRD' => [
                    'attendance-inquiry-approval-center',
                    'attendance-inquiry-approve-hrd',
                ],
                'Management' => [
                    'attendance-inquiry-approval-center',
                ],
                'Admin' => [
                    'attendance-inquiry-list-own',
                    'attendance-inquiry-create',
                    'attendance-inquiry-approval-center',
                    'attendance-inquiry-approve-hrd',
                ],
            ];

            // 3. Assign permission ke masing-masing role
            foreach ($roleAssignments as $roleName => $perms) {
                $role = Role::where('name', $roleName)->where('guard_name', 'web')->first();
                if ($role) {
                    $role->givePermissionTo($perms);
                    $this->command?->info("Permissions successfully assigned to role: {$roleName}");
                }
            }
        });

        $this->command?->info('Setup Permission Attendance Inquiry completed.');
    }
}
