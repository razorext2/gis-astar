<?php

namespace App\Services\Attendance;

class AttendanceCardService
{
    public function getAttendanceCards($model)
    {
        $user = auth()->user();
        $canValidate = $user->can('attendance-approve');

        // Jika user bisa validasi, tampilkan semua, jika tidak tampilkan milik dia saja
        $baseQuery = $model::query();
        if (! $canValidate) {
            $baseQuery->where('kode_pegawai', $user->kode_pegawai);
        }

        return [
            [
                'permission' => 'all',
                'label' => 'Absensi '.($model == 'App\Models\Attendance' ? 'Masuk' : 'Keluar').' Hari Ini',
                'count' => (clone $baseQuery)->whereDate('created_at', \Carbon\Carbon::today())->count(),
                'indicator' => 'Pegawai',
                'icon' => $model == 'App\Models\Attendance' ? 'icons.arrow-left-bracket' : 'icons.arrow-right-bracket',
                'color' => $model == 'App\Models\Attendance' ? 'blue' : 'red',
            ],
            [
                'permission' => 'all',
                'label' => 'Menunggu Validasi',
                'count' => (clone $baseQuery)
                    ->where('status', 0)
                    ->where('verified', 0)
                    ->count(),
                'indicator' => 'Data',
                'icon' => 'icons.question-circle',
                'color' => 'yellow',
            ],
            [
                'permission' => 'all',
                'label' => 'Disetujui',
                'count' => (clone $baseQuery)->where('status', 1)->count(),
                'indicator' => 'Data',
                'icon' => 'icons.check',
                'color' => 'green',
            ],
            [
                'permission' => 'all',
                'label' => 'Ditolak',
                'count' => (clone $baseQuery)->where('status', 2)->count(),
                'indicator' => 'Data',
                'icon' => 'icons.close',
                'color' => 'red',
            ],
        ];
    }
}
