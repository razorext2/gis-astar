<?php

/** Goal: Background job export poin teknisi ke Excel, Caller: ExportPointTransactions (Livewire), Deps: TechPointTransactionExport, ExportPointTransactionCompleted, ExportPointTransactionCompletedEvent */

namespace App\Jobs;

use App\Events\ExportPointTransactionCompletedEvent;
use App\Exports\TechPointTransactionExport;
use App\Models\PointTransactions;
use App\Models\User;
use App\Notifications\ExportPointTransactionCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CreatePointTechnicianTransactionExcelJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 300;

    public function __construct(
        public string $transactionID,
        public int $userId
    ) {}

    public function handle(): void
    {
        try {
            // ambil data transaksi untuk mendapatkan kuartal dan tahun
            $transaction = PointTransactions::where('transaction_id', $this->transactionID)->first();

            $quartal = $transaction?->quartal ?? 'Q';
            $year = $transaction?->year ?? now()->year;
            $fileName = "poin-teknisi-Q{$quartal}-{$year}.xlsx";

            // lakukan export di background
            (new TechPointTransactionExport($this->transactionID))->store("export/point/{$fileName}");

            // cari user yg melakukan request
            $user = User::find($this->userId);

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
        } catch (\Exception $e) {
            Log::error('Export poin teknisi gagal untuk user: '.$this->userId.' - Error: '.$e->getMessage());
        }
    }
}
