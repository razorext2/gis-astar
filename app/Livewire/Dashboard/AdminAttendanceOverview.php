<?php

namespace App\Livewire\Dashboard;

use App\Models\Attendance;
use App\Models\AttendanceOut;
use Carbon\Carbon;
use Livewire\Component;

class AdminAttendanceOverview extends Component
{
    public function render()
    {
        $today = Carbon::today();

        $attendance_out_today = AttendanceOut::whereDate('jam_keluar', $today)
            ->with(['pegawaiRelasi', 'user'])
            ->orderBy('jam_keluar', 'desc')
            ->get();

        $attendance_today = Attendance::whereDate('jam_masuk', $today)
            ->with(['pegawaiRelasi', 'user'])
            ->orderBy('jam_masuk', 'desc')
            ->get();

        return view('livewire.dashboard.admin-attendance-overview', [
            'attendance_today' => $attendance_today,
            'attendance_out_today' => $attendance_out_today,
            'today' => $today,
        ]);
    }
}
