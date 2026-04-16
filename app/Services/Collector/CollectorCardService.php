<?php

namespace App\Services\Collector;

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
}
