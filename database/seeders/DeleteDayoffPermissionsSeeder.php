<?php

namespace Database\Seeders;

/** Goal: Delete legacy dayoff permissions and cleanup all associations, Caller: php artisan db:seed --class=DeleteDayoffPermissionsSeeder, Deps: Spatie\Permission */

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

class DeleteDayoffPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionsToDelete = [
            'dayoff-confirm',
            'dayoff-create',
            'dayoff-delete',
            'dayoff-detail',
            'dayoff-edit',
            'dayoff-list',
        ];

        DB::transaction(function () use ($permissionsToDelete) {
            foreach ($permissionsToDelete as $permissionName) {
                // Mencari permission berdasarkan nama
                $permission = Permission::where('name', $permissionName)->first();

                if ($permission) {
                    // Spatie secara otomatis menangani penghapusan di tabel pivot 
                    // model_has_permissions dan role_has_permissions saat model didelete
                    $permission->delete();
                    
                    $this->command->info("Permission '{$permissionName}' berhasil dihapus.");
                } else {
                    $this->command->warn("Permission '{$permissionName}' tidak ditemukan, melewati...");
                }
            }
        });

        // Bersihkan cache permission agar perubahan langsung terasa
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        
        $this->command->info("Cache permission telah dibersihkan.");
    }
}
