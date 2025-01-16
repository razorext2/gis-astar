<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewTaskAssignedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $notification_id;
    protected $userId;
    protected $collect_id;
    protected $no_sr;

    /**
     * Create a new event instance.
     */
    public function __construct($notification_id, $userId, $collect_id, $no_sr)
    {
        $this->notification_id = $notification_id;
        $this->userId = $userId;
        $this->collect_id = $collect_id;
        $this->no_sr = $no_sr;
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
        return 'newTaskAssigned';
    }

    public function broadcastWith(): array
    {
        return [
            "id" => $this->notification_id,
            "message" => "Anda memiliki tagihan baru dengan kode tagihan: $this->no_sr yang harus anda tagih. Cek detail:",
            "button" => [
                "url" => route("collect.show", $this->collect_id),
                "label" => "Lihat Detail",
            ],
            "mark_as_read" => route("notification.mark-as-read", $this->notification_id),
            "created_at" => Carbon::now()->locale("id")->isoFormat("DD MMM YYYY HH:mm:ss"),
        ];
    }
}
