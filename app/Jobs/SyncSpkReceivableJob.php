<?php

/** Goal: Sinkronisasi sisa piutang satu SPK dari API BSI secara asynchronous, Caller: SyncReceivableDataHistoriesFromBsi command, Deps: SpkMain, ReceivableHistory, ReceivableHistoryDetail, Http, Log */

namespace App\Jobs;

use App\Models\Spk\ReceivableHistory;
use App\Models\Spk\ReceivableHistoryDetail;
use App\Models\Spk\SpkMain;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncSpkReceivableJob implements ShouldQueue
{
    use Queueable;

    /** @var int Jumlah retry jika job gagal */
    public int $tries = 3;

    /** @var int Timeout per attempt dalam detik */
    public int $timeout = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $spkId
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $spk = SpkMain::with('receivableHistories.details')->find($this->spkId);

        if (! $spk) {
            return;
        }

        $tipeTagihan = $this->resolveTipeTagihan($spk);

        if (! $tipeTagihan) {
            return;
        }

        $url = $tipeTagihan['api_sisa'].'&NomorPermintaanJual='.$spk->nomor_tagihan;

        try {
            $records = $this->fetchApiRecords($url);

            if (empty($records)) {
                return;
            }

            $apiCustomer = $records[0]['NamaCustomer'] ?? '';

            if (! $this->isCustomerNameMatching($spk, $apiCustomer)) {
                $this->warnCustomerMismatch($spk, $apiCustomer);

                return;
            }

            $history = $spk->receivableHistories()->latest()->first();

            if (! $history) {
                Log::channel('receivable_anomaly')->warning("Tidak ada header history untuk SPK {$spk->nomor_tagihan}. Lewati.", [
                    'nomor_tagihan' => $spk->nomor_tagihan,
                ]);

                return;
            }

            $syncedCount = $this->syncRecords($history, $records, $spk);

            if ($syncedCount > 0) {
                $history->recalculateSisaPiutangTotal();
                Log::info("Berhasil sinkronisasi {$syncedCount} piutang untuk SPK {$spk->nomor_tagihan}");
            }
        } catch (\Throwable $e) {
            $this->logAnomaly('Gagal sinkronisasi data penagihan SPK', $spk, ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /** Resolve config tipe tagihan untuk SPK. Return null jika tidak valid atau tidak ada api_sisa. */
    private function resolveTipeTagihan(SpkMain $spk): ?array
    {
        if (empty($spk->tipe_tagihan)) {
            return null;
        }

        $config = config('spk-config.spk_tipe_tagihan')[$spk->tipe_tagihan] ?? null;

        return ($config && ! empty($config['api_sisa'])) ? $config : null;
    }

    /**
     * Fetch dan parse records dari API BSI.
     * Return array records (bisa kosong) atau lempar exception jika gagal.
     *
     * @return array<int, array<string, mixed>>
     */
    private function fetchApiRecords(string $url): array
    {
        $response = Http::timeout(10)->retry(2, 200)->get($url);

        if (! $response->successful()) {
            return [];
        }

        $data = $response->json();

        if (($data['status'] ?? null) !== 'success') {
            return [];
        }

        return $data['data'] ?? [];
    }

    /** Proses semua records dari API ke database. Return jumlah record yang berhasil disimpan. */
    private function syncRecords(ReceivableHistory $history, array $records, SpkMain $spk): int
    {
        // Group existing details per nomor_piutang untuk menghindari N+1 di dalam loop
        $detailsByNomorPiutang = $history->details->groupBy('nomor_piutang');

        $synced = 0;

        foreach ($records as $record) {
            if ($this->processRecord($history, $record, $detailsByNomorPiutang, $spk)) {
                $synced++;
            }
        }

        return $synced;
    }

    /**
     * Proses satu record dari API BSI ke detail history.
     * Jika terjadi perubahan pada data angka (jumlah_piutang, total_bayar, sisa_piutang),
     * detail baru akan ditambahkan (create new) daripada di-update untuk menjaga riwayat perubahan.
     *
     * Return true jika record baru berhasil dibuat.
     */
    private function processRecord(
        ReceivableHistory $history,
        array $record,
        Collection $detailsByNomorPiutang,
        SpkMain $spk
    ): bool {
        $nomorPiutang  = $record['NomorPiutang'] ?? null;
        $jumlahPiutang = (int) ($record['JumlahPiutang'] ?? 0);
        $totalBayar    = (int) ($record['TotalBayar'] ?? 0);
        $sisaPiutang   = (int) ($record['SisaPiutang'] ?? 0);

        /** @var ReceivableHistoryDetail|null $existingDetail */
        $existingDetail = collect($detailsByNomorPiutang->get($nomorPiutang) ?? [])
            ->sortByDesc('created_at')
            ->first();

        if ($existingDetail) {
            // Jika tidak ada perubahan data angka — lewati
            if ($existingDetail->jumlah_piutang === $jumlahPiutang &&
                $existingDetail->total_bayar === $totalBayar &&
                $existingDetail->sisa_piutang === $sisaPiutang
            ) {
                return false;
            }

            // Sisa meningkat — kemungkinan human error di BSI
            if ($sisaPiutang > $existingDetail->sisa_piutang) {
                Log::warning("Sisa piutang meningkat tidak wajar untuk NomorPiutang {$nomorPiutang} (SPK {$spk->nomor_tagihan}). Data dilewati.");

                $this->logAnomaly('Sisa piutang meningkat tidak wajar — data dilewati', $spk, [
                    'nomor_piutang'        => $nomorPiutang,
                    'sisa_sebelumnya'      => $existingDetail->sisa_piutang,
                    'sisa_sesudah_api'     => $sisaPiutang,
                    'kemungkinan_penyebab' => 'Human error di BSI (misalnya: total bayar dikosongkan atau salah input)',
                ]);

                return false;
            }
        }

        // Buat detail baru (karena belum ada atau ada perbedaan angka).
        // sisa_sebelum diisi dari sisa_piutang record sebelumnya — null jika ini record pertama.
        $history->details()->create([
            'nomor_piutang'  => $nomorPiutang,
            'jumlah_piutang' => $jumlahPiutang,
            'total_bayar'    => $totalBayar,
            'sisa_piutang'   => $sisaPiutang,
            'sisa_sebelum'   => $existingDetail?->sisa_piutang,
            'is_dp'          => $existingDetail ? $existingDetail->is_dp : false,
            'source'         => 'API',
            'checked_at'     => now(),
        ]);

        return true;
    }

    /** Validasi bahwa nama customer dari API cocok dengan salah satu field nama di SPK */
    private function isCustomerNameMatching(SpkMain $spk, string $apiCustomer): bool
    {
        $apiSanitized  = $this->sanitizeAlphaNumeric($apiCustomer);
        $spkCompany    = $spk->company_name ?? '';
        $customerName  = $spk->customer['nama_perusahaan'] ?? '';
        $contactPerson = $spk->customer['contact_person'] ?? '';

        return $apiSanitized === $this->sanitizeAlphaNumeric($spkCompany)
            || ($customerName !== '' && $apiSanitized === $this->sanitizeAlphaNumeric($customerName))
            || ($contactPerson !== '' && $apiSanitized === $this->sanitizeAlphaNumeric($contactPerson));
    }

    /** Tampilkan warning dan log ketika nama customer tidak cocok */
    private function warnCustomerMismatch(SpkMain $spk, string $apiCustomer): void
    {
        $spkCompany    = $spk->company_name ?? '';
        $customerName  = $spk->customer['nama_perusahaan'] ?? '';
        $contactPerson = $spk->customer['contact_person'] ?? '';

        Log::warning("Nama Customer tidak cocok untuk SPK {$spk->nomor_tagihan}. API: {$apiCustomer}, Company: {$spkCompany}, Customer: {$customerName}, CP: {$contactPerson}");
    }

    private function sanitizeAlphaNumeric(string $text): string
    {
        return strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $text));
    }

    /** Log anomali sinkronisasi ke channel receivable_anomaly */
    private function logAnomaly(string $message, SpkMain $spk, array $context = []): void
    {
        Log::channel('receivable_anomaly')->warning($message, array_merge([
            'nomor_tagihan' => $spk->nomor_tagihan,
            'tipe_tagihan'  => $spk->tipe_tagihan,
            'detected_at'   => now()->toDateTimeString(),
        ], $context));
    }

    /**
     * Hitung backoff delay antar retry (exponential).
     *
     * @return array<int, int>
     */
    public function backoff(): array
    {
        return [10, 30, 60];
    }
}
