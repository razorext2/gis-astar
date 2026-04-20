<?php

namespace App\Livewire\Utils;

use Livewire\Component;

class PingChecker extends Component
{
    // Backend properties and updateLatency method removed.
    // The Ping Checker now operates fully local via AlpineJS on the frontend,
    // drastically reducing Livewire server-side request loads.

    public function render()
    {
        return view('livewire.utils.ping-checker');
    }
}
