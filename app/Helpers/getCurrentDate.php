<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

if (!function_exists('getCurrentDate')) {
    /**
     * Get the current date in a specific format.
     *
     * @return string
     */
    function getCurrentDate()
    {
        return Cache::remember('current_date', now()->addSeconds(10), function () {
            $today = Carbon::now();
            // perlu perbaikan
            $formattedDate = Carbon::parse($today)->locale('id')->isoFormat('YYYYMMDD_HHmmss');
            return $formattedDate;
        });
    }
}
