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
            'sales' => \App\Models\Sales::query()->where('status', 0),
            'collect' => \App\Models\Collector::query()->where('status', 2),
            'driver' => \App\Models\Driver::query()->where('status', 0),
        ];

        $query = $models[$this->id] ?? null;

        if ($query) {
            $query->with('pegawaiRelasi');

            if ($this->id === 'sales' && $user->hasRole('Marketing')) {
                $query->whereHas('userRelasi.roles', fn($r) => $r->where('name', 'Sales'));
            } elseif ($this->id === 'sales' && $user->hasAnyRole(['Marketing-JKT', 'Management-JKT'])) {
                $query->whereHas('userRelasi.roles', fn($r) => $r->where('name', 'Sales-JKT'));
            }
        }

        return view('livewire.utils.report-counter', [
            'count' => $query?->count() ?? 0,
            'id' => $this->id,
        ]);
    }

}
