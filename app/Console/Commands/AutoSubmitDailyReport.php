<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;

class AutoSubmitDailyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-submit-daily-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengubah status laporan harian menjadi disubmit secara otomatis setiap hari.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $reports = \App\Models\Spk\ProjectDailyReport::where('status', 'draft')
                ->update([
                    'status' => 'submitted',
                    'submitted_at' => now(),
                ]);

            if (! $reports) {
                throw new Exception('Gagal mengubah status laporan harian');
            }

            dump('Berhasil mengubah status laporan harian.');
        } catch (Exception $e) {
            dump('Gagal mengubah status laporan harian: '.$e->getMessage());
            logger()->error($e->getMessage());
        }

        dump('Proses mengubah status laporan harian selesai.');
    }
}
