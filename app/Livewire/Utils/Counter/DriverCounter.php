<?php

namespace App\Livewire\Utils\Counter;

use App\Services\Driver\DriverCounterService;
use Livewire\Component;

class DriverCounter extends Component
{
    public string $counterKey = 'driver';

    public function render()
    {
        $service = app(DriverCounterService::class);

        $count = $service->countNeedsApproval();

        return view('livewire.utils.counter.driver-counter', compact('count'));
    }
}
