<?php

namespace App\Livewire\Utils\Counter;

use App\Services\Spk\SpkCounterService;
use Livewire\Component;

class SpkPurchasingRequestCounter extends Component
{
    public string $counterKey = 'spk-purchasing-request';

    public function render()
    {
        $service = app(SpkCounterService::class);
        $count = $service->countNeedsAssignPurchasingRequestNumber();

        return view('livewire.utils.counter.spk-purchasing-request-counter', compact('count'));
    }
}
