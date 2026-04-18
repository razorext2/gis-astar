<?php

namespace App\Livewire\Dashboard;

use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserScheduleOverview extends Component
{
    public function render()
    {
        $getDay = Carbon::today()->locale('id')->isoFormat('dddd');

        $getPegawai = Pegawai::with([
            'jadwalRelasi' => function ($query) use ($getDay) {
                $query->where('hari', $getDay);
            },
        ])
            ->where('kode_pegawai', Auth::user()->kode_pegawai)
            ->first();

        $getJadwal = $getPegawai?->jadwalRelasi->first();

        return view('livewire.dashboard.user-schedule-overview', [
            'getDay' => $getDay,
            'getJadwal' => $getJadwal,
        ]);
    }
}
