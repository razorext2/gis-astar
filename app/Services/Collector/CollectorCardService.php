<?php

namespace App\Services\Collector;

use App\Models\Collector;

class CollectorCardService
{
    public function getCollectorCards($model)
    {
        $baseQuery = $model::query();

        return [
            [
                'permission' => 'all',
                'label' => 'Belum di Assign',
                'count' => (clone $baseQuery)->whereNull('assign_to')->count(),
                'indicator' => 'Tagihan',
                'icon' => 'icons.question-circle',
                'color' => 'red',
            ],
            [
                'permission' => 'all',
                'label' => 'Berjalan',
                'count' => (clone $baseQuery)->where('bill_status', 1)->count(),
                'indicator' => 'Tagihan',
                'icon' => 'icons.cash',
                'color' => 'blue',
            ],
            [
                'permission' => 'all',
                'label' => 'Tertunda',
                'count' => (clone $baseQuery)->where('bill_status', 3)->count(),
                'indicator' => 'Tagihan',
                'icon' => 'icons.lock-time',
                'color' => 'yellow',
            ],
            [
                'permission' => 'all',
                'label' => 'Selesai',
                'count' => (clone $baseQuery)->where('bill_status', 2)->count(),
                'indicator' => 'Tagihan',
                'icon' => 'icons.check-circle',
                'color' => 'green',
            ],
        ];
    }

    public function getCollectorReportCards()
    {
        $baseQuery = Collector::query();
        $user = auth()->user();
        $canValidate = $user->can('collect-approve');

        if (! $canValidate) {
            $baseQuery->where('kode_pegawai', $user->kode_pegawai);
        }

        return [
            [
                'permission' => 'all',
                'label' => 'Belum di Lengkapi',
                'count' => (clone $baseQuery)->where('status', 0)->count(),
                'indicator' => 'Laporan',
                'icon' => 'icons.question-circle',
                'color' => 'yellow',
            ],
            [
                'permission' => 'all',
                'label' => 'Diajukan',
                'count' => (clone $baseQuery)->where('status', 2)->count(),
                'indicator' => 'Laporan',
                'icon' => 'icons.clipboard-check',
                'color' => 'yellow',
            ],
            [
                'permission' => 'all',
                'label' => 'Diterima',
                'count' => (clone $baseQuery)->where('status', 1)->count(),
                'indicator' => 'Laporan',
                'icon' => 'icons.check-circle',
                'color' => 'green',
            ],
            [
                'permission' => 'all',
                'label' => 'Ditolak',
                'count' => (clone $baseQuery)->where('status', 3)->count(),
                'indicator' => 'Laporan',
                'icon' => 'icons.close',
                'color' => 'red',
            ],
        ];
    }
}
