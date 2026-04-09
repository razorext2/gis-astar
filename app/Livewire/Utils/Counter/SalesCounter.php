<?php

namespace App\Livewire\Utils\Counter;

use App\Services\Sales\SalesCounterService;
use Livewire\Component;

class SalesCounter extends Component
{
    public string $counterKey = 'sales';

    public function render()
    {
        $service = app(SalesCounterService::class);
        $count = $service->countNeedsApproval();

        return view('livewire.utils.counter.sales-counter', compact('count'));
    }
}
