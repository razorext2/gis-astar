<?php

/** Goal: Centralize logic for managing national holidays, including fetching from API. Caller: Livewire Components, Deps: Holiday model */

namespace App\Services\System;

use App\Models\System\Holiday;
use Illuminate\Support\Facades\Http;

class HolidayService
{
    /**
     * Fetch holidays from the API for a specific year.
     */
    public function fetchFromApi(int $year)
    {
        $url = config('services.national_holiday_api.url');

        $response = Http::get($url, ['year' => $year]);

        if ($response->failed()) {
            $response->throw();
        }

        return $response->json();
    }

    /**
     * Store selected holidays into the database.
     */
    public function storeHolidays(array $selectedHolidays)
    {
        foreach ($selectedHolidays as $holiday) {
            Holiday::updateOrCreate(
                ['date' => $holiday['date']],
                ['name' => $holiday['name']]
            );
        }
    }
    /**
     * Get existing holiday dates for a specific year.
     */
    public function getExistingDates(int $year): array
    {
        return Holiday::whereYear('date', $year)
            ->pluck('date')
            ->map(fn($date) => $date->format('Y-m-d'))
            ->toArray();
    }

    /**
     * Delete a holiday.
     */
    public function deleteHoliday(int $id)
    {
        return Holiday::destroy($id);
    }
}
