<?php

namespace App\Services\Collector;

class CollectorCounterService
{
    public function countNeedsApproval()
    {
        return \App\Models\Collector::where('status', 2)->count();
    }
}
