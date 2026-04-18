<?php

namespace App\Livewire\Dashboard;

use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserAttendanceHistory extends Component
{
    public function render()
    {
        $today = Carbon::today();

        $attendance_all = Pegawai::with([
            'attendanceRelasi',
            'latestAttendanceOutRelasi',
        ])
            ->select('kode_pegawai', 'nick_name')
            ->where('kode_pegawai', Auth::user()->kode_pegawai)
            ->whereHas('attendanceRelasi', function ($query) {
                $query->where('status', 1);
            })
            ->get()
            ->map(function ($pegawai) {
                return [
                    'kode_pegawai' => $pegawai->kode_pegawai,
                    'nick_name' => $pegawai->nick_name,
                    'status_in' => $pegawai->attendanceRelasi->status ?? null,
                    'jam_masuk' => $pegawai->attendanceRelasi->jam_masuk ?? null,
                    'status_out' => $pegawai->latestAttendanceOutRelasi->status ?? null,
                    'latest_jam_keluar' => $pegawai->latestAttendanceOutRelasi->jam_keluar ?? null,
                ];
            })
            ->sortBy(function ($pegawai) {
                return [
                    $pegawai['latest_jam_keluar'] ? -$pegawai['latest_jam_keluar']->timestamp : PHP_INT_MAX,
                    $pegawai['jam_masuk'] ? $pegawai['jam_masuk']->timestamp : PHP_INT_MAX,
                ];
            });

        return view('livewire.dashboard.user-attendance-history', [
            'attendance_all' => $attendance_all,
        ]);
    }
}
