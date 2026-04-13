<?php

namespace App\Livewire\Utils\Counter;

use App\Services\Spk\SpkCounterService;
use Livewire\Component;

class SpkDeliveryCounter extends Component
{
    public string $counterKey = 'spk-delivery';

    public function render()
    {
        $service = app(SpkCounterService::class);
        $count = $service->countSpkDoesNotOnDelivery();

        return view('livewire.utils.counter.spk-delivery-counter', compact('count'));
    }
}
