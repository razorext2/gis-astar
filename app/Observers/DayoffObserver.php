<?php

namespace App\Observers;

use App\Models\Dayoff;
use Illuminate\Support\Facades\Cache;

class DayoffObserver
{
    /**
     * Handle the Dayoff "created" event.
     */
    public function created(Dayoff $dayoff): void
    {
        //
    }

    /**
     * Handle the Dayoff "updated" event.
     */
    public function updated(Dayoff $dayoff): void
    {
        if (Cache::get('dayoff_data_' . $dayoff->id)) {
            Cache::forget('dayoff_data_' . $dayoff->id);
        }
    }

    /**
     * Handle the Dayoff "deleted" event.
     */
    public function deleted(Dayoff $dayoff): void
    {
        if (Cache::get('dayoff_data_' . $dayoff->id)) {
            Cache::forget('dayoff_data_' . $dayoff->id);
        }
    }
}
