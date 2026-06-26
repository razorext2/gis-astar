<?php

/** Goal: Background job export poin teknisi ke Excel, Caller: ExportPointTransactions (Livewire), Deps: TechPointTransactionExport, ExportPointTransactionCompleted, ExportPointTransactionCompletedEvent */

namespace App\Jobs;

use App\Events\ExportPointTransactionCompletedEvent;
use App\Exports\TechPointTransactionExport;
use App\Helpers\ErrorLogger;
use App\Models\PointTransactions;
use App\Models\User;
use App\Notifications\ExportPointTransactionCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CreatePointTechnicianTransactionExcelJob implements ShouldQueue
{
    use Queueable;

    public int $timeout = 300;

    public int $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $transactionID,
        public readonly int $userId,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $transaction = PointTransactions::where('transaction_id', $this->transactionID)->first();

        if (! $transaction) {
            throw new \RuntimeException("PointTransaction [{$this->transactionID}] tidak ditemukan.");
        }

        $user = User::find($this->userId);

        if (! $user) {
            throw new \RuntimeException("User [{$this->userId}] tidak ditemukan.");
        }

        $quartal = $transaction->quartal ?? 'Q';
        $year = $transaction->year ?? now()->year;
        $fileName = "poin-teknisi-Q{$quartal}-{$year}.xlsx";

        // lakukan export di background
        (new TechPointTransactionExport($this->transactionID))->store("export/point/{$fileName}");

        // buat notifikasi ke user yg melakukan request
        $user->notify(new ExportPointTransactionCompleted($fileName, $quartal, $year));

        // ambil data notifikasi terakhir
        $notification = $user->notifications()->latest()->first();

        // broadcast jika export selesai
        broadcast(new ExportPointTransactionCompletedEvent(
            $notification->id,
            $this->userId,
            $fileName,
            $quartal,
            $year,
        ));
    }

    /**
     * Handle a job failure — dipanggil setelah semua retry habis.
     */
    public function failed(\Throwable $exception): void
    {
        ErrorLogger::log($exception, 'CreatePointTechnicianTransactionExcelJob permanently failed', [
            'transaction_id' => $this->transactionID,
            'user_id' => $this->userId,
        ]);
    }

    /**
     * @return array<int, int>
     */
    public function backoff(): array
    {
        return [10, 30, 60];
    }
}
