<?php

/** Goal: Event broadcast ketika export poin teknisi selesai, Caller: CreatePointTechnicianTransactionExcelJob, Deps: - */

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExportPointTransactionCompletedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        protected string $notifID,
        protected int $userID,
        protected string $filename,
        protected string $quartal,
        protected string $year
    ) {}

    /**
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("notifications.{$this->userID}"),
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
        return [
            'id' => $this->notifID,
            'message' => "Proses ekspor poin teknisi Q{$this->quartal} {$this->year} telah selesai. Silahkan download berkas dengan klik tombol berikut.",
            'button' => [
                'url' => route('export.point.download', $this->filename),
                'label' => 'Download Laporan',
            ],
            'mark_as_read' => route('notification.mark-as-read', $this->notifID),
            'created_at' => Carbon::now()->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss'),
        ];
    }
}
