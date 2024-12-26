<?php

namespace App\Observers;

use App\Models\Collector;
use Illuminate\Support\Facades\Cache;

class CollectObserver
{
    /**
     * Handle the Collector "created" event.
     */
    public function created(Collector $collector): void
    {
        Cache::forget('collector_all_datas');
    }

    /**
     * Handle the Collector "updated" event.
     */
    public function updated(Collector $collector): void
    {
        if (Cache::get('collector_data_' . $collector->id)) {
            Cache::forget('collector_data_' . $collector->id);
        }

        Cache::forget('collector_all_datas');
    }

    /**
     * Handle the Collector "deleted" event.
     */
    public function deleted(Collector $collector): void
    {
        if (Cache::get('collector_data_' . $collector->id)) {
            Cache::forget('collector_data_' . $collector->id);
        }

        Cache::forget('collector_all_datas');
    }
}
