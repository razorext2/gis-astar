<?php

namespace App\Services\Sales;

use App\Models\Sales;

class SalesCardService
{
    public function getSalesReportCards()
    {
        $baseQuery = Sales::query();
        $user = auth()->user();

        if ($user->cannot('sales-approve')) {
            $baseQuery->where('kode_pegawai', $user->kode_pegawai);
        } else {
            $allowedRoles = SalesRegionResolver::resolveForUser($user);

            if (! empty($allowedRoles)) {
                $baseQuery->whereHas('userRelasi.roles', fn ($q) => $q->whereIn('name', $allowedRoles));
            }
        }

        return [
            [
                'permission' => 'all',
                'label' => 'Belum Disetujui',
                'count' => (clone $baseQuery)->where('status', 0)->count(),
                'indicator' => 'Laporan',
                'icon' => 'icons.question-circle',
                'color' => 'yellow',
            ],
            [
                'permission' => 'all',
                'label' => 'Disetujui',
                'count' => (clone $baseQuery)->where('status', 1)->count(),
                'indicator' => 'Laporan',
                'icon' => 'icons.check-circle',
                'color' => 'green',
            ],
            [
                'permission' => 'all',
                'label' => 'Ditolak',
                'count' => (clone $baseQuery)->where('status', 2)->count(),
                'indicator' => 'Laporan',
                'icon' => 'icons.close',
                'color' => 'red',
            ],
            [
                'permission' => 'all',
                'label' => 'Total Laporan',
                'count' => (clone $baseQuery)->count(),
                'indicator' => 'Laporan',
                'icon' => 'icons.clipboard',
                'color' => 'blue',
            ],
        ];
    }
}
