<?php

namespace App\Livewire\Utils\Counter;

use App\Services\Collector\CollectorCounterService;
use Livewire\Component;

class CollectorIdcNonPpnCounter extends Component
{
    public string $counterKey = 'collect-idc-non-ppn';

    public function render()
    {
        $service = app(CollectorCounterService::class);
        $count = $service->countIdcNonPpnNeedsAssignment();

        return view('livewire.utils.counter.collector-idc-non-ppn-counter', compact('count'));
    }
}
