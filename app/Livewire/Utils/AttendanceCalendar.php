<?php

namespace App\Livewire\Utils;

use App\Models\Attendance;
use App\Models\AttendanceOut;
use App\Models\Pegawai;
use Carbon\CarbonPeriod;
use Livewire\Component;

class AttendanceCalendar extends Component
{
    public $id;
    public $clockIn = [];
    public $clockOut = [];

    public function showAttendance($date)
    {
        $this->clockIn = Attendance::select('jam_masuk', 'longitude', 'latitude', 'photoURL')
            ->where('kode_pegawai', $this->id)
            ->whereDate('jam_masuk', $date)
            ->get();

        $this->clockOut = AttendanceOut::select('jam_keluar', 'longitude', 'latitude', 'photoURL')
            ->where('kode_pegawai', $this->id)
            ->whereDate('jam_keluar', $date)
            ->get();
    }

    public function render()
    {
        $this->id = auth()->user()->kode_pegawai;

        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $dates = collect(range(0, $startOfMonth->dayOfWeek - 1))
            ->map(fn() => null)
            ->merge(CarbonPeriod::create($startOfMonth, $endOfMonth)
                ->toArray());

        $attendanceData = Attendance::where('kode_pegawai', $this->id)->get();

        return view('livewire.utils.attendance-calendar', [
            'dates' => $dates,
            'attendanceData' => $attendanceData,
            'clockIn' => $this->clockIn,
            'clockOut' => $this->clockOut
        ]);
    }
}
