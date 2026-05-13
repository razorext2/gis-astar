<?php

namespace App\Livewire\Dashboard;

use App\Models\TechnicianPoints;
use Livewire\Component;

class TechnicianLeaderboard extends Component
{
    public function render()
    {
        $leaderboard = collect();
        if (auth()->user()->can('technician-list') || auth()->user()->can('point-approve')) {
            $leaderboard = TechnicianPoints::with('pegawai.userRelasi')
                ->selectRaw('kode_pegawai, sum(point) as total_points')
                ->where('is_redeemable', 1)
                ->where('is_redeemed', 0)
                ->groupBy('kode_pegawai')
                ->orderByDesc('total_points')
                ->take(5)
                ->get();
        }

        return view('livewire.dashboard.technician-leaderboard', compact('leaderboard'));
    }
}
