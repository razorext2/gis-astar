<?php

namespace App\Livewire\Utils;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class PingChecker extends Component
{
    public int $latency = 0;
    public string $pingClass = 'text-gray-500 dark:text-white';

    #[\Livewire\Attributes\On('updateLatency')]
    public function updateLatency($ms)
    {
        $this->latency = (int) $ms;

        $this->pingClass = match (true) {
            $this->latency < 100 => 'text-green-500 dark:text-green-400',
            $this->latency < 300 => 'text-yellow-500 dark:text-yellow-400',
            default => 'text-red-500 dark:text-red-400',
        };
    }

    public function render()
    {
        return view('livewire.utils.ping-checker');
    }
}
