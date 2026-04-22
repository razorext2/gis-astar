<?php

namespace App\Services\Driver;

use App\Models\Driver;

class DriverCardService
{
    public function getDriverReportCards()
    {
        $user = auth()->user();
        $baseQuery = Driver::query();

        if ($user->can('driver-approve')) {
            // Kumpulkan role Driver yang boleh dilihat user ini
            $roles = collect([
                'Driver-Jkt' => 'driver-list-jkt',
                'Driver-Medan' => 'driver-list-medan',
            ])->filter(fn ($permission) => $user->can($permission))->keys()->toArray();

            $baseQuery->where(function ($q) use ($roles, $user) {
                // 1. Driver dengan kode_pegawai yang sesuai role
                $q->when(! empty($roles), fn ($q) => $q->where(fn ($q) => $q
                    ->whereNotNull('kode_pegawai')
                    ->whereHas('user.roles', fn ($role) => $role->whereIn('name', $roles))
                ));

                // 2. Driver tanpa kode_pegawai (guest) yang di-assign oleh user ini
                $q->orWhere(fn ($q) => $q
                    ->whereNull('kode_pegawai')
                    ->where('assign_by', $user->id)
                );
            });
        } else {
            // User biasa — hanya lihat data miliknya sendiri
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
                'count' => (clone $baseQuery)->where('status', 2)->count(),
                'indicator' => 'Laporan',
                'icon' => 'icons.close',
                'color' => 'red',
            ],
        ];
    }
}
