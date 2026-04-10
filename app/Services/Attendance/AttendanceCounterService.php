<?php

namespace App\Services\Attendance;

use App\Models\Attendance;
use App\Models\AttendanceOut;

class AttendanceCounterService
{
    public function countAttendanceInNotVerified()
    {
        if (auth()->user()->can('attendance-approve')) {
            return Attendance::where('verified', 0)
                ->where('status', 0)
                ->count();
        } else {
            return Attendance::where('kode_pegawai', auth()->user()->kode_pegawai)
                ->where('verified', 0)
                ->where('status', 0)
                ->count();
        }
    }

    public function countAttendanceOutNotVerified()
    {
        if (auth()->user()->can('attendance-approve')) {
            return AttendanceOut::where('verified', 0)
                ->where('status', 0)
                ->count();
        } else {
            return AttendanceOut::where('kode_pegawai', auth()->user()->kode_pegawai)
                ->where('verified', 0)
                ->where('status', 0)
                ->count();
        }
    }
}
