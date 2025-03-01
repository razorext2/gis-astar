<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Card extends Component
{
    public function render()
    {
        $datas = [
            [
                'label' => 'Total pengguna',
                'count' => \App\Models\User::count(),
                'indicator' => 'Pegawai',
            ],
            [
                'label' => 'Absen hari ini',
                'count' => \App\Models\Attendance::whereDate('created_at', \Carbon\Carbon::today())
                    ->count(),
                    'indicator' => 'Orang',
            ],
            // [
            //     'label' => 'Lap. kolektor blm acc',
            //     'count' => \App\Models\Collector::where('status', 2)->count(),
            //     'indicator' => 'Data',
            // ],
            // [
            //     'label' => 'Lap. sales blm acc',
            //     'count' => \App\Models\Sales::where('status', 0)->count(),
            //     'indicator' => 'Data',
            // ],
        ];

        return view('livewire.components.card', ['data' => $datas, 'totalData' => count($datas)]);
    }
}
