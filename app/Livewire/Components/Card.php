<?php

namespace App\Livewire\Components;

use App\Models\Attendance;
use App\Models\AttendanceOut;
use App\Models\Collector;
use App\Models\Sales;
use App\Services\Attendance\AttendanceCardService;
use App\Services\Spk\SpkCardService;
use Livewire\Component;

class Card extends Component
{
    public string $type = 'dashboard';

    public array $cards = [];

    public function render()
    {
        $datas = $this->resolveCards();

        $totalData = 0;
        foreach ($datas as $data) {
            $permission = $data['permission'] ?? 'all';
            if ($permission === 'all' || auth()->user()->can($permission)) {
                $totalData++;
            }
        }

        return view('livewire.components.card', ['data' => $datas, 'totalData' => $totalData]);
    }

    protected function resolveCards(): array
    {
        if (! empty($this->cards)) {
            return $this->cards;
        }

        return match ($this->type) {
            'spk' => $this->getSpkCards(),
            'dashboard' => $this->getDashboardCards(),
            'attendancein' => $this->getAttendanceCards(Attendance::class),
            'attendanceout' => $this->getAttendanceCards(AttendanceOut::class),
            default => [],
        };
    }

    protected function getDashboardCards(): array
    {
        return [
            [
                'permission' => 'users-create',
                'label' => 'Pengguna',
                'count' => \App\Models\User::count(),
                'indicator' => 'Pegawai',
                'icon' => 'icons.users',
                'color' => 'red',
            ],
            [
                'permission' => 'pegawai-list',
                'label' => 'Absen hari ini',
                'count' => Attendance::whereDate('created_at', \Carbon\Carbon::today())
                    ->count(),
                'indicator' => 'Orang',
                'icon' => 'icons.check',
                'color' => 'red',
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
                'color' => 'red',
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
                'color' => 'red',
            ],
        ];
    }

    protected function getSpkCards(): array
    {
        return app(SpkCardService::class)->getSpkCards();
    }

    protected function getAttendanceCards($model)
    {
        return app(AttendanceCardService::class)->getAttendanceCards($model);
    }
}
