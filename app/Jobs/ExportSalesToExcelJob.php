<?php

namespace App\Jobs;

use App\Events\ExportSalesCompletedEvent;
use App\Exports\SalesExport;
use App\Models\User;
use App\Notifications\ExportCompleted;
use App\Notifications\ExportSalesCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ExportSalesToExcelJob implements ShouldQueue
{
    use Queueable;

    public $user;
    public $fromDate;
    public $toDate;
    public $role;

    /**
     * Create a new job instance.
     */
    public function __construct($user, $fromDate, $toDate, $role)
    {
        $this->user = $user;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->role = $role;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // buat nama file
            $fileName = rand(1, 999999) . '-' . $this->fromDate . '-' . $this->toDate . '.xlsx';

            // lakukan export di background
            (new SalesExport($this->fromDate, $this->toDate, $this->role))->store("export/$fileName");

            // cari user yg melakukan request
            $user = User::find($this->user);

            // buat notifikasi ke user yg melakukan request
            $user->notify(new ExportSalesCompleted($fileName, $this->fromDate, $this->toDate));

            // ambil data notifikasi terakhir
            $notification = $user->notifications()->latest()->first();

            // broadcast jika export selesai
            broadcast(new ExportSalesCompletedEvent($notification->id, $this->user, $fileName, $this->fromDate, $this->toDate));

        } catch (\Exception $e) {
            Log::error('Export sales failed for user: ' . $this->user . ' - Error: ' . $e->getMessage());
        }
    }
}
