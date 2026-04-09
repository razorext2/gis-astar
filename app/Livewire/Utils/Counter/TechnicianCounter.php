<?php

namespace App\Livewire\Utils\Counter;

use App\Services\Technician\TechnicianCounterService;
use Livewire\Component;

class TechnicianCounter extends Component
{
    public string $counterKey = 'technician';

    public function render()
    {
        $service = app(TechnicianCounterService::class);

        $approval = $service->countNeedsApproval();
        $revision = $service->countNeedsRevision();

        return view('livewire.utils.counter.technician-counter', compact('approval', 'revision'));
    }
}
