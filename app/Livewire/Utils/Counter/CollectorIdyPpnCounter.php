<?php

namespace App\Livewire\Utils\Counter;

use App\Services\Collector\CollectorCounterService;
use Livewire\Component;

class CollectorIdyPpnCounter extends Component
{
    public string $counterKey = 'collector-idy-ppn';

    public function render()
    {
        $service = app(CollectorCounterService::class);
        $count = $service->countIdyPpnNeedsAssignment();

        return view('livewire.utils.counter.collector-idy-ppn-counter', compact('count'));
    }
}
