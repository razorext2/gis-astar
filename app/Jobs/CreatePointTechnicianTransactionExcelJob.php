<?php

namespace App\Jobs;

use App\Exports\TechPointTransactionExport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CreatePointTechnicianTransactionExcelJob implements ShouldQueue
{
    use Queueable;

    public $transactionID;

    /**
     * Create a new job instance.
     */
    public function __construct($transactionID)
    {
        $this->transactionID = $transactionID;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new TechPointTransactionExport($this->transactionID))->store("export/" . $this->transactionID . ".xlsx");
    }
}
