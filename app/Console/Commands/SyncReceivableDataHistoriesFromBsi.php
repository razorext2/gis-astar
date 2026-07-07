<?php

/** Goal: Sinkronisasi data sisa piutang terbaru dari API BSI dengan dispatch queue job, Caller: Scheduler / Artisan, Deps: SpkMain, SyncSpkReceivableJob */

namespace App\Console\Commands;

use App\Jobs\SyncSpkReceivableJob;
use App\Models\Spk\SpkMain;
use Illuminate\Console\Command;

class SyncReceivableDataHistoriesFromBsi extends Command
{
    protected $signature = 'sync:receivable-data';

    protected $description = 'Sinkronisasi data terbaru penagihan SPK dari API BSI';

    public function handle(): int
    {
        $spkIds = SpkMain::query()
            ->whereNotNull('nomor_tagihan')
            ->where('status_nomor_tagihan', 1)
            ->pluck('id');

        foreach ($spkIds as $spkId) {
            SyncSpkReceivableJob::dispatch($spkId);
        }

        $this->info('Sinkronisasi data penagihan SPK didelegasikan ke Queue (' . $spkIds->count() . ' job).');

        return self::SUCCESS;
    }
}
