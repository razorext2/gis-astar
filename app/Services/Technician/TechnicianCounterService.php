<?php

namespace App\Services\Technician;

use App\Models\Technician;

class TechnicianCounterService
{
    public function countNeedsApproval()
    {
        return Technician::needApprove()->count();
    }

    public function countNeedsRevision()
    {
        return Technician::needRevision()->count();
    }
}
