<?php

namespace App\Livewire\Utils\Counter;

use App\Services\Collector\CollectorCounterService;
use Livewire\Component;

class CollectCounter extends Component
{
    public string $counterKey = 'collect';

    public function render()
    {
        $service = app(CollectorCounterService::class);

        $count = $service->countNeedsApproval();

        return view('livewire.utils.counter.collect-counter', compact('count'));
    }
}
