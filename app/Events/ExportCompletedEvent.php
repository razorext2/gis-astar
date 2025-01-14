<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class ExportCompletedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification_id;
    public $userId;
    public $fileName;

    /**
     * Create a new event instance.
     */
    public function __construct($notification_id, $userId, $fileName)
    {
        $this->notification_id = $notification_id;
        $this->userId = $userId;
        $this->fileName = $fileName;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("exportFiles.$this->userId"),
        ];
    }

    public function broadcastAs()
    {
        return 'exportCompleted';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->notification_id,
            'message' => 'Proses ekspor telah selesai. Silahkan download berkas dengan klik tombol berikut.',
            'url' => route('export.collector.download', $this->fileName),
            'mark_as_read' => route('notification.mark-as-read', $this->notification_id),
            'created_at' => Carbon::now()->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss'),
        ];
    }
}
