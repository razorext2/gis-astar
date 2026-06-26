<?php

/** Goal: Render a list of the 5 most recent SPKs, Caller: Dashboard, Deps: App\Models\Spk\SpkMain */

namespace App\Livewire\Dashboard;

use App\Models\Spk\SpkMain;
use Livewire\Component;

class RecentSpk extends Component
{
    public function render()
    {
        $recentSpks = collect();
        if (auth()->user()->can('spk-list')) {
            $recentSpks = SpkMain::with(['addedBy'])->latest()->take(5)->get();
        }

        return view('livewire.dashboard.recent-spk', compact('recentSpks'));
    }
}
