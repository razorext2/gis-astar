<?php

namespace App\Livewire\Components;

use App\Models\Collector;
use App\Models\Sales;
use Livewire\Component;

class Card extends Component
{
    public function render()
    {
        $datas = [
            [
                'permission' => 'users-create',
                'label' => 'Total pengguna',
                'count' => \App\Models\User::count(),
                'indicator' => 'Pegawai',
            ],
            [
                'permission' => 'pegawai-list',
                'label' => 'Absen hari ini',
                'count' => \App\Models\Attendance::whereDate('created_at', \Carbon\Carbon::today())
                    ->count(),
                'indicator' => 'Orang',
            ],
            [
                'permission' => 'collect-edit',
                'label' => 'Lap. kolektor blm acc',
                'count' => auth()->user()->hasRole('Collector')
                    ? Collector::where('status', 2)
                        ->where('kode_pegawai', auth()->user()->kode_pegawai)
                        ->count()
                    : Collector::where('status', 2)
                        ->count(),
                'indicator' => 'Laporan',
            ],
            [
                'permission' => 'sales-edit',
                'label' => 'Total lap. sales blm acc',
                'count' => auth()->user()->hasRole('Sales')
                    ? Sales::where('status', 0)
                        ->where('kode_pegawai', auth()->user()->kode_pegawai)
                        ->count()
                    : Sales::where('status', 0)
                        ->count(),
                'indicator' => 'Laporan',
            ],
        ];

        $totalData = 0;

        foreach ($datas as $data) {
            if (auth()->user()->can($data['permission'])) {
                $totalData++;
            }
        }

        return view('livewire.components.card', ['data' => $datas, 'totalData' => $totalData]);
    }
}
