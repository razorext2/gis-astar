<?php

namespace App\Services\Collector;

class CollectorCounterService
{
    public function countNeedsApproval()
    {
        return \App\Models\Collector::where('status', 2)->count();
    }

    public function countIdcNonPpnNeedsAssignment()
    {
        return \App\Models\CollectTask::whereNull('assign_to')->count();
    }

    public function countIdcPpnNeedsAssignment()
    {
        return \App\Models\CollectTaskPpn::whereNull('assign_to')->count();
    }

    public function countIdyPpnNeedsAssignment()
    {
        return \App\Models\CollectIdyPpn::whereNull('assign_to')->count();
    }
}
