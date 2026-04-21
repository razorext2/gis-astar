<?php

namespace App\Services\Technician;

use App\Models\Team;
use App\Models\Technician;

class TechnicianCardService
{
    public function getTechnicianReportCards()
    {
        $baseQuery = Technician::query();
        $user = auth()->user();
        $canValidate = $user->can('technician-approve');

        if (! $canValidate) {
            $baseQuery->where('kode_pegawai', $user->kode_pegawai);
        }

        return [
            [
                'permission' => 'all',
                'label' => 'Total Laporan',
                'count' => (clone $baseQuery)->count(),
                'indicator' => 'Laporan',
                'icon' => 'icons.clipboard',
                'color' => 'blue',
            ],
            [
                'permission' => 'all',
                'label' => 'Belum di Validasi',
                'count' => (clone $baseQuery)->where('status', 0)->count(),
                'indicator' => 'Laporan',
                'icon' => 'icons.clipboard',
                'color' => 'yellow',
            ],
            [
                'permission' => 'all',
                'label' => 'Butuh di Revisi',
                'count' => (clone $baseQuery)->where('status', 2)->count(),
                'indicator' => 'Laporan',
                'icon' => 'icons.clipboard',
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
        ];
    }

    public function getTechnicianTeamCards()
    {
        return [
            [
                'permission' => 'all',
                'label' => 'Total Tim',
                'count' => Team::count(),
                'indicator' => 'Tim',
                'icon' => 'icons.users-group',
                'color' => 'blue',
            ],
            [
                'permission' => 'all',
                'label' => 'Total Teknisi Terdaftar',
                'count' => \App\Models\User::whereHas('roles', fn ($r) => $r->where('name', 'Teknisi'))->count(),
                'indicator' => 'Orang',
                'icon' => 'icons.users',
                'color' => 'green',
            ],
        ];
    }
}
