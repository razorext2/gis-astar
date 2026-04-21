<?php

namespace App\Services\Driver;

use App\Models\Driver;

class DriverCardService
{
    public function getDriverReportCards()
    {
        $baseQuery = Driver::query();
        $user = auth()->user();
        $canValidate = $user->can('driver-approve');

        if (! $canValidate) {
            $baseQuery->where('kode_pegawai', $user->kode_pegawai);
        }

        return [
            [
                'permission' => 'all',
                'label' => 'Perlu Disetujui',
                'count' => (clone $baseQuery)->needApprove()->count(),
                'indicator' => 'Laporan',
                'icon' => 'icons.question-circle',
                'color' => 'yellow',
            ],
            [
                'permission' => 'all',
                'label' => 'Perlu Diassign',
                'count' => (clone $baseQuery)->where('status', 4)->count(),
                'indicator' => 'Laporan',
                'icon' => 'icons.chalkboard-user',
                'color' => 'yellow',
            ],
            [
                'permission' => 'all',
                'label' => 'Belum Diupdate',
                'count' => (clone $baseQuery)->where('status', 5)->count(),
                'indicator' => 'Laporan',
                'icon' => 'icons.clipboard',
                'color' => 'yellow',
            ],
            [
                'permission' => 'all',
                'label' => 'Butuh Revisi',
                'count' => (clone $baseQuery)->where('status', 3)->count(),
                'indicator' => 'Laporan',
                'icon' => 'icons.clipboard',
                'color' => 'yellow',
            ],
            [
                'permission' => 'all',
                'label' => 'Disetujui',
                'count' => (clone $baseQuery)->where('status', 1)->count(),
                'indicator' => 'Laporan',
                'icon' => 'icons.check',
                'color' => 'green',
            ],
            [
                'permission' => 'all',
                'label' => 'Ditolak',
                'count' => (clone $baseQuery)->where('status', 1)->count(),
                'indicator' => 'Laporan',
                'icon' => 'icons.close',
                'color' => 'red',
            ],
        ];
    }
}
