<?php

namespace App\Services\DailyReport;

use App\Exceptions\BusinessException;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class HourlyReportServices
{
    public function compareTime($startTime, $endTime): bool
    {
        $startTime = Carbon::parse($startTime);
        $endTime = Carbon::parse($endTime);

        if ($endTime->lessThanOrEqualTo($startTime)) {
            throw new BusinessException('Waktu aktivitas selesai harus lebih besar dari waktu mulai.');
        }

        return true;
    }

    public function validateNoOverlap($startTime, $endTime, Collection $activities): bool
    {
        $startTime = Carbon::parse($startTime);
        $endTime = Carbon::parse($endTime);

        foreach ($activities as $activity) {

            $existingStart = Carbon::parse($activity->start_time);
            $existingEnd = Carbon::parse($activity->end_time);

            if ($startTime->lt($existingEnd) && $endTime->gt($existingStart)) {
                throw new BusinessException(
                    "Waktu aktivitas bentrok dengan aktivitas lain ({$existingStart->format('H:i')} - {$existingEnd->format('H:i')})."
                );
            }
        }

        return true;
    }
}
