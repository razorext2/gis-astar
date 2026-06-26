<?php

/** Goal: Broadcast event ketika export laporan gagal, Caller: ExportReportJob::failed(), Deps: None */

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReportExportFailedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        protected string $notificationId,
        protected int $userId,
        protected string $reportLabel,
        protected string $fromDate,
        protected string $toDate,
    ) {}

    /**
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("notifications.{$this->userId}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'exportFailed';
    }

    /**
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        $from = Carbon::parse($this->fromDate)->locale('id')->isoFormat('DD MMMM YYYY');
        $to = Carbon::parse($this->toDate)->locale('id')->isoFormat('DD MMMM YYYY');

        return [
            'id' => $this->notificationId,
            'message' => "Proses ekspor Laporan {$this->reportLabel} gagal. Periode {$from} s/d {$to}. Silahkan coba kembali.",
            'created_at' => Carbon::now()->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss'),
        ];
    }
}
