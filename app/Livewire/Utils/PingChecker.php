<?php

namespace App\Livewire\Utils;

use Livewire\Component;

class PingChecker extends Component
{
    public $pingMs = null;
    public $isOnline = true;

    public function render()
    {
        return view('livewire.utils.ping-checker');
    }
}
