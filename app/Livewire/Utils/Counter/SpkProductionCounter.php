<?php

namespace App\Livewire\Utils\Counter;

use App\Services\Spk\SpkCounterService;
use Livewire\Component;

class SpkProductionCounter extends Component
{
    public string $counterKey = 'spk-production';

    public function render()
    {
        $service = app(SpkCounterService::class);
        $count = $service->countSpkDoesNotHaveProductionProgress();

        return view('livewire.utils.counter.spk-production-counter', compact('count'));
    }
}
