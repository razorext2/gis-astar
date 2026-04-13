<?php

namespace App\Livewire\Utils\Counter;

use App\Services\Spk\SpkCounterService;
use Livewire\Component;

class SpkMainCounter extends Component
{
    public string $counterKey = 'spk-main';

    public function render()
    {
        $service = app(SpkCounterService::class);
        $count = $service->countNeedsValidation();

        return view('livewire.utils.counter.spk-main-counter', compact('count'));
    }
}
