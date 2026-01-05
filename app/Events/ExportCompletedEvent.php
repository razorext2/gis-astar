<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExportCompletedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $notification_id;

    protected $userId;

    protected $fileName;

    protected $date;

    /**
     * Create a new event instance.
     */
    public function __construct($notification_id, $userId, $fileName, $date)
    {
        $this->notification_id = $notification_id;
        $this->userId = $userId;
        $this->fileName = $fileName;
        $this->date = $date;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("notifications.$this->userId"),
        ];
    }

    public function broadcastAs()
    {
        return 'exportCompleted';
    }

    public function broadcastWith(): array
    {
        $date = Carbon::parse($this->date)->locale('id')->isoFormat('DD MMMM YYYY');

        return [
            'id' => $this->notification_id,
            'message' => "Proses ekspor telah selesai. Laporan penagihan untuk tanggal $date telah berhasil diekspor. Silahkan download berkas dengan klik tombol berikut.",
            'button' => [
                'url' => route('export.collector.download', $this->fileName),
                'label' => 'Download Laporan',
            ],
            'mark_as_read' => route('notification.mark-as-read', $this->notification_id),
            'created_at' => Carbon::now()->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss'),
        ];
    }
}
