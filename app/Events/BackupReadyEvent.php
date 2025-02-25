<?php

namespace App\Events;

use App\Models\Backup;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class BackupReadyEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    protected string $name;
    protected string $user_id;

    /**
     * Create a new event instance.
     */
    public function __construct($name, $user_id)
    {
        $this->name = $name;
        $this->user_id = $user_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("notifications.$this->user_id"),
        ];
    }

    public function broadcastAs()
    {
        return 'backupReady';
    }

    public function broadcastWith()
    {
        $data = Backup::where('name', $this->name)->first();

        $data->update(['status' => 'success']);

        return [
            "id" => 123456,
            "message" => "Cadangan dengan nama $this->name, telah selesai dicadangkan. Silahkan unduh.",
        ];
    }
}
