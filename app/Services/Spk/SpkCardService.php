<?php

namespace App\Services\Spk;

use App\Models\Spk\SpkMain;

class SpkCardService
{
    public function getSpkCards()
    {
        $user = auth()->user();
        $canValidate = $user->can('spk-validate');

        // Jika user bisa validasi, tampilkan semua, jika tidak tampilkan milik dia saja
        $baseQuery = SpkMain::query();
        if (! $canValidate) {
            $baseQuery->where('added_by', $user->id);
        }

        return [
            [
                'permission' => 'all',
                'label' => 'Menunggu Validasi',
                'count' => (clone $baseQuery)->where('status_approval', 0)->count(),
                'indicator' => 'SPK',
                'icon' => 'icons.clipboard-check',
                'color' => 'yellow',
            ],
            [
                'permission' => 'all',
                'label' => 'SPK Booked',
                'count' => (clone $baseQuery)->where('is_booked', true)->count(),
                'indicator' => 'SPK',
                'icon' => 'icons.bookmark',
                'color' => 'blue',
            ],
            [
                'permission' => 'all',
                'label' => 'SPK Ditolak',
                'count' => (clone $baseQuery)->where('status_approval', 2)->count(),
                'indicator' => 'SPK',
                'icon' => 'icons.exclamation-circle',
                'color' => 'red',
            ],
            [
                'permission' => 'all',
                'label' => 'SPK Selesai',
                'count' => (clone $baseQuery)->where('status', 6)->count(),
                'indicator' => 'SPK',
                'icon' => 'icons.badge-check',
                'color' => 'green',
            ],
        ];
    }
}
