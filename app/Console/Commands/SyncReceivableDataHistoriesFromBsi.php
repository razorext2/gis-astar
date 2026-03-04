<?php

namespace App\Console\Commands;

use App\Models\Spk\SpkMain;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncReceivableDataHistoriesFromBsi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:receivable-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi data terbaru penagihan SPK';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // ambil data spk yang nomor_tagihannya tidak null / udah diinput
        $spks = SpkMain::with('receivableHistories')
            ->whereNotNull('nomor_tagihan')
            ->where('status_nomor_tagihan', 1)
            ->get();

        foreach ($spks as $spk) {
            // buat url
            $url = 'https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchSisa1&NomorPermintaanJual='.$spk->nomor_tagihan;

            try {
                // akses api
                $response = Http::timeout(10)
                    ->retry(2, 200)
                    ->get($url);

                if (! $response->successful()) {
                    continue;
                }

                $data = $response->json();

                if ($data['status'] !== 'success') {
                    continue;
                }

                $sisaSebelum = (float) $spk->receivableHistories->last()->sisa_piutang_sesudah;
                $sisaSesudah = (float) $data['data'][0]['SisaPiutang'];
                $selisih = $sisaSebelum - $sisaSesudah;

                // jika sisa piutang saat ini (dari API) tidak sama dengan sisa piutang dari database
                if ($sisaSesudah !== $sisaSebelum) {
                    // update data
                    $spk->receivableHistories()->create([
                        'nomor_sr' => $spk->nomor_tagihan,
                        'total_piutang' => (float) $data['data'][0]['JumlahPiutang'],
                        'sisa_piutang_sebelum' => $sisaSebelum,
                        'sisa_piutang_sesudah' => $sisaSesudah,
                        'selisih' => $selisih,
                        'source' => 'API',
                        'checked_at' => now(),
                    ]);

                    dump('Berhasil sinkronisasi data penagihan SPK '.$spk->nomor_tagihan);
                }
            } catch (\Throwable $e) {
                dump('Gagal sinkronisasi data penagihan SPK '.$spk->nomor_tagihan);
                logger()->error($e->getMessage());
            }
        }

        dump('Sinkronisasi data penagihan SPK selesai.');
    }
}
