<?php

namespace App\Services\DailyReport;

use App\Models\Spk\ProjectAssignment;

class DailyReportCounterService
{
    public function countNeedsToComplete()
    {
        return ProjectAssignment::needsToComplete()->count();
    }
}
