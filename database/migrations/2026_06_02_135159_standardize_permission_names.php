<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    private const RENAME_MAP = [
        'invoice-add' => 'invoice-create',
        'invoice-detail' => 'invoice-view',
        'spk-detail' => 'spk-view',
        'spk-history' => 'spk-history-view',
        'spk-lampiran' => 'spk-lampiran-view',
        'spk-billing-index' => 'spk-billing-list',
        'spk-billing-update' => 'spk-billing-edit',
        'spk-update-informasi-pengiriman' => 'spk-informasi-pengiriman-edit',
        'spk-update-no-kontrak-pengiriman' => 'spk-no-kontrak-pengiriman-edit',
        'spk-update-no-tagihan-idcnonppn' => 'spk-no-tagihan-idcnonppn-edit',
        'spk-update-no-tagihan-idcppn' => 'spk-no-tagihan-idcppn-edit',
        'spk-update-no-tagihan-idyppn' => 'spk-no-tagihan-idyppn-edit',
        'technician-update' => 'technician-edit',
        'team-member-add' => 'team-member-create',
        'team-member-remove' => 'team-member-delete',
        'dayoff-detail' => 'dayoff-view',

        'dayoff-confirm' => 'dayoff-approve',
        'spk-validate' => 'spk-approve',
        'spk-validate-pengiriman' => 'spk-pengiriman-approve',
        'laporan-harian-validate' => 'laporan-harian-approve',
        'produksi-validate' => 'produksi-approve',
        'collect-task-validate' => 'collect-task-approve',
        'collect-idy-ppn-validate' => 'collect-idy-ppn-approve',
        'collect-task-ppn-validate' => 'collect-task-ppn-approve',

        'assign-laporan-harian' => 'laporan-harian-assign',
        'unassign-laporan-harian' => 'laporan-harian-unassign',
        'assign-laporan-harian-spk' => 'laporan-harian-spk-assign',
        'unassign-laporan-harian-spk' => 'laporan-harian-spk-unassign',
        
        'all-team' => 'team-list-all',
        'technician-all' => 'technician-list-all',
        'leave-view-all' => 'leave-list-all',
        'leave-view-own' => 'leave-list-own',
        'vt-view-all' => 'vt-list-all',
        'pegawai-attendance' => 'attendance-view',
        'pegawai-timeline' => 'attendance-timeline-view',
        'capture' => 'capture-view',
        'capture-route' => 'capture-route-view',
        'kurir-bank' => 'kurir-bank-list',
    ];

    public function up(): void
    {
        foreach (self::RENAME_MAP as $oldName => $newName) {
            $permission = Permission::where('name', $oldName)->first();
            if ($permission) {
                $permission->update(['name' => $newName]);
            }
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }

    public function down(): void
    {
        foreach (self::RENAME_MAP as $oldName => $newName) {
            $permission = Permission::where('name', $newName)->first();
            if ($permission) {
                $permission->update(['name' => $oldName]);
            }
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
};
