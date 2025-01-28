<?php

namespace App\Jobs;

use App\Models\User;
use App\Events\ExportCompletedEvent;
use App\Exports\CollectorExport;
use App\Notifications\ExportCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ExportToExcelJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 300;
    protected $date;
    protected $status;
    protected $type;
    protected string $fileName;
    protected $userId;

    /**
     * Create a new job instance.
     */
    public function __construct($date, $status, $type, $fileName, $userId)
    {
        $this->date = $date;
        $this->status = $status;
        $this->type = $type;
        $this->fileName = $fileName;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // cari usernya
            $user = User::find($this->userId);

            // lakukan export di background
            (new CollectorExport($this->date, $this->status, $this->type))->store("export/$this->fileName");

            // berikan notifikasi ke user yang melakukan request
            $user->notify(new ExportCompleted($this->fileName, $this->date));

            // ambil data notifikasi terakhir
            $notification = $user->notifications()->latest()->first();

            // broadcast jika export selesai
            broadcast(new ExportCompletedEvent($notification->id, $this->userId, $this->fileName, $this->date));
        } catch (\Exception $e) {
            Log::error('Export failed for user: ' . $this->userId . ' - Error: ' . $e->getMessage());
        }
    }
}
