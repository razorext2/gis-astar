<?php

namespace App\Services\Attendance;

use App\Models\Attendance;
use App\Models\AttendanceOut;

class AttendanceCardService
{
    protected function user()
    {
        return auth()->user();
    }

    public function getAttendanceCards($model)
    {
        $canValidate = $this->user()->can('attendance-approve');

        // Jika user bisa validasi, tampilkan semua, jika tidak tampilkan milik dia saja
        $baseQuery = $model::query();
        if (! $canValidate) {
            $baseQuery->where('kode_pegawai', $this->user()->kode_pegawai);
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

    public function getAttendanceTodayCards()
    {
        return [
            [
                'permission' => 'all',
                'label' => 'Total Absensi Masuk Hari Ini',
                'count' => Attendance::whereDate('created_at', \Carbon\Carbon::today())
                    ->where('status', 1)
                    ->where('verified', 1)
                    ->count(),
                'indicator' => 'Pegawai',
                'icon' => 'icons.arrow-left-bracket',
                'color' => 'blue',
            ],
            [
                'permission' => 'all',
                'label' => 'Total Absensi Keluar Hari Ini',
                'count' => AttendanceOut::whereDate('created_at', \Carbon\Carbon::today())->count(),
                'indicator' => 'Pegawai',
                'icon' => 'icons.arrow-right-bracket',
                'color' => 'red',
            ],
        ];
    }
}
