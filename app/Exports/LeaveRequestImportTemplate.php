<?php

/** Goal: Export template Excel kosong untuk import data cuti lama, Caller: ImportLeaveRequest Livewire, Deps: LeaveType, Maatwebsite/Excel */

namespace App\Exports;

use App\Models\LeaveRequest\LeaveType;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LeaveRequestImportTemplate implements WithMultipleSheets
{
    /**
     * @return array<int, object>
     */
    public function sheets(): array
    {
        return [
            new LeaveRequestImportDataSheet,
            new LeaveRequestImportReferenceSheet,
        ];
    }
}
