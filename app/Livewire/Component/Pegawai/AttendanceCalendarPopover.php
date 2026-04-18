<?php

namespace App\Livewire\Component\Pegawai;

use App\Models\Attendance;
use App\Models\AttendanceOut;
use Carbon\Carbon;
use Livewire\Component;

class AttendanceCalendarPopover extends Component
{
    public $date;
    public $pegawaiId;
    public $kodePegawai;

    public function mount($date, $pegawaiId, $kodePegawai)
    {
        $this->date = $date;
        $this->pegawaiId = $pegawaiId;
        $this->kodePegawai = $kodePegawai;
    }

    public function render()
    {
        $dateFormatted = Carbon::parse($this->date)->format('Y-m-d');

        $attendance = Attendance::whereDate('jam_masuk', $dateFormatted)
            ->where('kode_pegawai', $this->kodePegawai)
            ->get();

        $attendanceOut = AttendanceOut::whereDate('jam_keluar', $dateFormatted)
            ->where('kode_pegawai', $this->kodePegawai)
            ->get();

        return view('livewire.component.pegawai.attendance-calendar-popover', [
            'attendance' => $attendance,
            'attendanceOut' => $attendanceOut,
        ]);
    }

    public function getPositionStatus($status)
    {
        switch ($status) {
            case 1:
                return [
                    'label' => 'Dalam Perjalanan',
                    'class' => 'bg-yellow-600/10 text-yellow-600 dark:bg-yellow-600/20 dark:text-yellow-400',
                ];
            case 2:
                return [
                    'label' => 'Stand By',
                    'class' => 'bg-green-600/10 text-green-600 dark:bg-green-600/20 dark:text-green-400',
                ];
            case 3:
                return [
                    'label' => 'Onsite',
                    'class' => 'bg-red-600/10 text-red-600 dark:bg-red-600/20 dark:text-red-400',
                ];
            default:
                return [
                    'label' => 'Unknown',
                    'class' => 'bg-gray-600/10 text-gray-600 dark:bg-zinc-600/20 dark:text-gray-400',
                ];
        }
    }
}
