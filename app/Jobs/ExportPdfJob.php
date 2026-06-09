<?php

/** Goal: Generate PDF dari model tertentu lalu notify user via notifikasi + broadcast, Caller: SpkController/Generate, Deps: BaseFileDownload, BasicMakePdfCompletedEvent, DomPDF, User */

namespace App\Jobs;

use App\Events\BasicMakePdfCompletedEvent;
use App\Helpers\ErrorLogger;
use App\Models\User;
use App\Notifications\BaseFileDownload;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ExportPdfJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 120;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly int $userId,
        public readonly string $dataModel,
        public readonly string $dataId,
        public readonly string $paperType,
        public readonly string $paperOrientation,
        public readonly string $viewTemplate,
        public readonly string $message,
        public readonly string $route,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::find($this->userId);

        if (! $user) {
            throw new \RuntimeException("User [{$this->userId}] tidak ditemukan.");
        }

        $data = $this->dataModel::find($this->dataId);

        if (! $data) {
            throw new \RuntimeException("Model [{$this->dataModel}] dengan ID [{$this->dataId}] tidak ditemukan.");
        }

        $pdf = Pdf::loadView($this->viewTemplate, ['data' => $data]);
        $pdf->setPaper($this->paperType, $this->paperOrientation);
        $pdf->save($this->dataId.'.pdf', 'pdf');

        $user->notify(new BaseFileDownload(
            route: $this->route,
            parameters: [$this->dataId],
            message: $this->message,
            label: 'Download PDF',
        ));

        $latestNotificationId = $user->notifications()->latest()->first()->id;

        broadcast(new BasicMakePdfCompletedEvent(
            notification_id: $latestNotificationId,
            user_id: $user->id,
            message: $this->message,
            route: $this->route,
            parameters: [$this->dataId],
            label: 'Download PDF',
        ));
    }

    /**
     * Handle a job failure — dipanggil setelah semua retry habis.
     */
    public function failed(\Throwable $exception): void
    {
        ErrorLogger::log($exception, 'ExportPdfJob permanently failed', [
            'user_id' => $this->userId,
            'model' => $this->dataModel,
            'id' => $this->dataId,
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
