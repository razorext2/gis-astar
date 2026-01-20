<?php

namespace App\Livewire\Utils;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReportCounter extends Component
{
    public string $id;

    public function render()
    {
        $user = Auth::user();

        $models = [
            'sales' => \App\Models\Sales::needApprove(),
            'collect' => \App\Models\Collector::needApprove(),
            'driver' => \App\Models\Driver::needApprove(),
            'technician' => \App\Models\Technician::needApprove(),
        ];

        $query = $models[$this->id] ?? null;

        $roleMap = [
            'sales' => [
                'sales-export-medan' => ['rel' => 'userRelasi.roles', 'role' => 'Sales'],
                'sales-export-jkt' => ['rel' => 'userRelasi.roles', 'role' => 'Sales-JKT'],
                'sales-export-pku' => ['rel' => 'userRelasi.roles', 'role' => 'Sales-PKU'],
            ],
            'driver' => [
                'driver-list-jkt' => ['rel' => 'user.roles', 'role' => 'Driver-Jkt'],
                'driver-list-medan' => ['rel' => 'user.roles', 'role' => 'Driver-Medan'],
            ],
        ];

        $count = 0;

        if ($query && isset($roleMap[$this->id])) {
            foreach ($roleMap[$this->id] as $permission => $config) {
                if ($user->can($permission)) {
                    $count += (clone $query)
                        ->whereHas($config['rel'], fn ($r) => $r->where('name', $config['role']))
                        ->count();
                }
            }
        }

        return view('livewire.utils.report-counter', [
            'count' => $count ?? 0,
            'id' => $this->id,
        ]);
    }
}
