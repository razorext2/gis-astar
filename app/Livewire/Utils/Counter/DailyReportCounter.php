<?php

namespace App\Livewire\Utils\Counter;

use App\Services\DailyReport\DailyReportCounterService;
use Livewire\Component;

class DailyReportCounter extends Component
{
    public string $counterKey = 'daily-report';

    public function render()
    {
        $service = app(DailyReportCounterService::class);
        $count = $service->countNeedsToComplete();

        return view('livewire.utils.counter.daily-report-counter', compact('count'));
    }
}
