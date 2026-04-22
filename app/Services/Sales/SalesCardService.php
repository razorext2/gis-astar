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
            // Map: role Sales -> closure pemeriksa akses user
            // Tambah region baru = cukup tambah 1 baris di sini
            $regionMap = [
                'Sales-IDY'     => fn () => $user->hasAnyRole(['HRD-IDY', 'Marketing-IDY']) || $user->can('sales-export-idy'),
                'Kurir-Bank'    => fn () => $user->hasAnyRole(['Kasir', 'Piutang']) || $user->can('sales-export-kurir-bank'),
                'Sales'         => fn () => $user->hasRole('Marketing') || $user->can('sales-export-medan'),
                'Sales-JKT'     => fn () => $user->hasAnyRole(['Marketing-JKT', 'Management-JKT']) || $user->can('sales-export-jkt'),
                'Sales-PKU'     => fn () => $user->hasAnyRole(['Marketing-PKU', 'Management-PKU']) || $user->can('sales-export-pku'),
                'Sales-Agrotec' => fn () => $user->can('sales-export-agrotec') || $user->hasRole('Service-Agrotec'),
            ];

            $allowedRoles = collect($regionMap)
                ->filter(fn ($check) => $check())
                ->keys()
                ->toArray();

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
