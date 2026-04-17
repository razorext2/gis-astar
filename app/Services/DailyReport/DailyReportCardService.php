<?php

namespace App\Services\DailyReport;

use App\Models\Spk\ProjectAssignment;

class DailyReportCardService
{
    public function getDailyReportCards()
    {
        $baseQuery = ProjectAssignment::query();
        $user = auth()->user();
        $canValidate = $user->can('laporan-harian-validate');

        if (! $canValidate) {
            $baseQuery->where('assign_to', $user->id);
        }

        return [
            [
                'permission' => 'all',
                'label' => 'Total Proyek',
                'count' => $baseQuery->count(),
                'indicator' => 'Proyek',
                'icon' => 'icons.clipboard',
                'color' => 'blue',
            ],
            [
                'permission' => 'all',
                'label' => 'Proses Pengerjaan',
                'count' => (clone $baseQuery)
                    ->where('status', 'in_progress')
                    ->orWhere('status', 'assigned')
                    ->count(),
                'indicator' => 'Proyek',
                'icon' => 'icons.lock-time',
                'color' => 'yellow',
            ],
            [
                'permission' => 'all',
                'label' => 'Proyek Selesai',
                'count' => (clone $baseQuery)
                    ->where('status', 'completed')
                    ->count(),
                'indicator' => 'Proyek',
                'icon' => 'icons.clipboard-check',
                'color' => 'green',
            ],
        ];
    }
}
