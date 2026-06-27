<?php

/** Goal: Provide reusable logic for attendance features, Caller: ApiAttendanceController, AttendanceInquiry components, Deps: - */

namespace App\Services\Attendance;

class AttendanceService
{
    /**
     * Check if coordinates are in Medan boundary.
     */
    public static function isInMedan(?string $latitude, ?string $longitude): bool
    {
        if ($latitude === null || $longitude === null) {
            return false;
        }

        $lat = (float) $latitude;
        $lng = (float) $longitude;

        return $lat >= 3.50 && $lat <= 3.78 && $lng >= 98.58 && $lng <= 98.75;
    }
}
