<?php

namespace App\Console\Commands;

use App\Models\Spk\SpkMain;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
    public function handle(): int
    {
        // ambil SPK yang sudah memiliki nomor tagihan dan statusnya aktif
        $spks = SpkMain::with('receivableHistories')
            ->whereNotNull('nomor_tagihan')
            ->where('status_nomor_tagihan', 1)
            ->get();

        foreach ($spks as $spk) {
            $configKey = $spk->tipe_tagihan;

            if (empty($configKey)) {
                continue;
            }

            // ambil konfigurasi API berdasarkan tipe tagihan SPK (e.g. BSI, BRI, dll)
            $tipeTagihan = config('spk-config.spk_tipe_tagihan')[$configKey] ?? null;

            if (! $tipeTagihan || empty($tipeTagihan['api_sisa'])) {
                continue;
            }

            $url = $tipeTagihan['api_sisa'].'&NomorPermintaanJual='.$spk->nomor_tagihan;

            try {
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

                $record = $data['data'][0];
                $apiCustomer = $record['NamaCustomer'] ?? '';

                $spkCompany = $spk->company_name ?? '';
                $customerName = $spk->customer['nama_perusahaan'] ?? '';
                $contactPerson = $spk->customer['contact_person'] ?? '';

                $apiCustomerSanitized = $this->sanitizeAlphaNumeric($apiCustomer);

                // validasi: nama customer dari API harus cocok dengan salah satu field nama di SPK
                // untuk mencegah history tersimpan pada SPK yang salah
                $matchFound = (
                    $apiCustomerSanitized === $this->sanitizeAlphaNumeric($spkCompany) ||
                    ($customerName !== '' && $apiCustomerSanitized === $this->sanitizeAlphaNumeric($customerName)) ||
                    ($contactPerson !== '' && $apiCustomerSanitized === $this->sanitizeAlphaNumeric($contactPerson))
                );

                if (! $matchFound) {
                    $this->warn("Nama Customer tidak cocok untuk SPK {$spk->nomor_tagihan}. API: {$apiCustomer}, Company: {$spkCompany}, Customer: {$customerName}, CP: {$contactPerson}");

                    continue;
                }

                // field di DB bertipe bigint, cast ke int agar perbandingan konsisten
                $sisaSebelum = (int) ($spk->receivableHistories->last()?->sisa_piutang_sesudah ?? 0);
                $sisaSesudah = (int) $record['SisaPiutang'];
                $selisih = $sisaSebelum - $sisaSesudah;

                // abaikan jika sisa piutang sesudah LEBIH BESAR dari sebelumnya (selisih negatif)
                // secara bisnis ini tidak wajar — piutang seharusnya hanya berkurang, bukan bertambah
                // kemungkinan penyebab: human error di input BSI (misalnya: total bayar dikosongkan)
                if ($selisih < 0) {
                    $this->warn("Sisa piutang meningkat tidak wajar untuk SPK {$spk->nomor_tagihan}. Data dilewati.");

                    Log::channel('receivable_anomaly')->warning('Sisa piutang meningkat tidak wajar — data dilewati', [
                        'nomor_tagihan'       => $spk->nomor_tagihan,
                        'tipe_tagihan'        => $spk->tipe_tagihan,
                        'customer'            => $apiCustomer,
                        'jumlah_piutang_api'  => (int) $record['JumlahPiutang'],
                        'total_bayar_api'     => (int) $record['TotalBayar'],
                        'sisa_sebelumnya'     => $sisaSebelum,
                        'sisa_sesudah_api'    => $sisaSesudah,
                        'selisih'             => $selisih,
                        'kemungkinan_penyebab' => 'Human error di BSI (misalnya: total bayar dikosongkan atau salah input)',
                        'detected_at'         => now()->toDateTimeString(),
                    ]);

                    continue;
                }

                // hanya simpan history jika ada perubahan sisa piutang dari data sebelumnya
                if ($sisaSesudah !== $sisaSebelum) {
                    $spk->receivableHistories()->create([
                        'nomor_sr' => $spk->nomor_tagihan,
                        'total_piutang' => (int) $record['JumlahPiutang'],
                        'sisa_piutang_sebelum' => $sisaSebelum,
                        'sisa_piutang_sesudah' => $sisaSesudah,
                        'selisih' => $selisih,
                        'source' => 'BSI',
                        'checked_at' => now(),
                    ]);

                    $this->info("Berhasil sinkronisasi data penagihan SPK {$spk->nomor_tagihan}");
                }
            } catch (\Throwable $e) {
                $this->error("Gagal sinkronisasi data penagihan SPK {$spk->nomor_tagihan}");
                logger()->error($e->getMessage());
            }
        }

        $this->info('Sinkronisasi data penagihan SPK selesai.');

        return self::SUCCESS;
    }

    /**
     * Sanitize string to uppercase alphanumeric only.
     */
    private function sanitizeAlphaNumeric(string $text): string
    {
        return strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $text));
    }
}
