<?php

namespace App\Livewire\Dashboard;

/** Goal: Render technician leaderboard, Caller: Dashboard view, Deps: TechnicianPoints, Pegawai */

use App\Models\TechnicianPoints;
use Livewire\Attributes\Computed;
use Livewire\Component;

class TechnicianLeaderboard extends Component
{
    #[Computed]
    public function leaderboard(): \Illuminate\Support\Collection
    {
        if (! auth()->user()->can('technician-list') && ! auth()->user()->can('point-approve')) {
            return collect();
        }

        return TechnicianPoints::query()
            ->with(['pegawai' => fn ($q) => $q->select(['kode_pegawai', 'full_name', 'nick_name'])])
            ->selectRaw('kode_pegawai, SUM(point) as total_points')
            ->where('is_redeemable', true)
            ->where('is_redeemed', false)
            ->groupBy('kode_pegawai')
            ->orderByDesc('total_points')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard.technician-leaderboard', [
            'leaderboard' => $this->leaderboard,
        ]);
    }
}
