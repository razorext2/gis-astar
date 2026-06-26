<?php

/** Goal: Broadcast event ketika export laporan selesai, Caller: ExportReportJob, Deps: None */

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReportExportCompletedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        protected string $notificationId,
        protected int $userId,
        protected string $fileName,
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
        return 'exportCompleted';
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
            'message' => "Proses ekspor Laporan {$this->reportLabel} telah selesai. Periode {$from} s/d {$to}. Silahkan download berkas.",
            'button' => [
                'url' => route('export.report.download', $this->fileName),
                'label' => 'Download Laporan',
            ],
            'mark_as_read' => route('notification.mark-as-read', $this->notificationId),
            'created_at' => Carbon::now()->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss'),
        ];
    }
}
