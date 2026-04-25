<?php

/** Goal: Background job export invoice ke Excel, Caller: Livewire Export, Deps: InvoiceExport, ExportInvoiceCompleted, ExportInvoiceCompletedEvent */

namespace App\Jobs;

use App\Events\ExportInvoiceCompletedEvent;
use App\Exports\InvoiceExport;
use App\Models\User;
use App\Notifications\ExportInvoiceCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ExportInvoiceToExcelJob implements ShouldQueue
{
    use Queueable;

    public $userId;
    public $fromDate;
    public $toDate;
    public $region;
    public $tipeTagihan;

    /**
     * Create a new job instance.
     */
    public function __construct($userId, $fromDate, $toDate, $region, $tipeTagihan = null)
    {
        $this->userId = $userId;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->region = $region;
        $this->tipeTagihan = $tipeTagihan;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // buat nama file
            $fileName = rand(1, 999999) . '-invoice-' . $this->fromDate . '-' . $this->toDate . '.xlsx';

            // lakukan export di background
            (new InvoiceExport($this->fromDate, $this->toDate, $this->region, $this->tipeTagihan))
                ->store("export/invoice/$fileName");

            // cari user yg melakukan request
            $user = User::find($this->userId);

            // buat notifikasi ke user yg melakukan request
            $user->notify(new ExportInvoiceCompleted($fileName, $this->fromDate, $this->toDate));

            // ambil data notifikasi terakhir
            $notification = $user->notifications()->latest()->first();

            // broadcast jika export selesai
            broadcast(new ExportInvoiceCompletedEvent(
                $notification->id,
                $this->userId,
                $fileName,
                $this->fromDate,
                $this->toDate
            ));
        } catch (\Exception $e) {
            Log::error('Export invoice failed for user: ' . $this->userId . ' - Error: ' . $e->getMessage());
        }
    }
}
