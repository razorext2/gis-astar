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
                'label' => 'Pengguna',
                'count' => \App\Models\User::count(),
                'indicator' => 'Pegawai',
                'icon' => 'icons.users',
            ],
            [
                'permission' => 'pegawai-list',
                'label' => 'Absen hari ini',
                'count' => \App\Models\Attendance::whereDate('created_at', \Carbon\Carbon::today())
                    ->count(),
                'indicator' => 'Orang',
                'icon' => 'icons.check',
            ],
            [
                'permission' => 'collect-edit',
                'label' => 'Kolektor',
                'count' => auth()->user()->hasRole('Collector')
                    ? Collector::needApprove()
                        ->where('kode_pegawai', auth()->user()->kode_pegawai)
                        ->count()
                    : Collector::needApprove()
                        ->count(),
                'indicator' => 'Laporan',
                'icon' => 'icons.wallet',
            ],
            [
                'permission' => 'sales-edit',
                'label' => 'Sales',
                'count' => auth()->user()->hasRole('Sales')
                    ? Sales::needApprove()
                        ->where('kode_pegawai', auth()->user()->kode_pegawai)
                        ->count()
                    : Sales::needApprove()
                        ->count(),
                'indicator' => 'Laporan',
                'icon' => 'icons.cash-register',
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
