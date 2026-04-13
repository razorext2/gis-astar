<?php

namespace App\Livewire\Utils\Counter;

use App\Services\Collector\CollectorCounterService;
use Livewire\Component;

class CollectorIdcPpnCounter extends Component
{
    public string $counterKey = 'collect-idc-ppn';

    public function render()
    {
        $service = app(CollectorCounterService::class);
        $count = $service->countIdcPpnNeedsAssignment();

        return view('livewire.utils.counter.collector-idc-ppn-counter', compact('count'));
    }
}
