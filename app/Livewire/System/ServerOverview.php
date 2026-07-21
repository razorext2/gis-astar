<?php

namespace App\Livewire\System;

use App\Models\ServerMonitor;
use Livewire\Component;

class ServerOverview extends Component
{
    public function render()
    {
        $servers = ServerMonitor::with('latestLog')->get();

        return view('livewire.system.server-overview', [
            'servers' => $servers,
        ]);
    }
}
