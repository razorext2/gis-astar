<?php

namespace App\Events;

use App\Models\CollectTask;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskAssigned implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $task;

    /**
     * Create a new event instance.
     */
    public function __construct(CollectTask $task)
    {
        $this->task = $task;
    }

    public function broadcastOn()
    {
        return [new Channel('collectorNewAssign')];
    }

    public function broadcastWith()
    {
        return [
            'messages' => "[{$this->task->created_at}], Tagihan baru dengan No. SR '{$this->task->no_sr}' akan di lakukan oleh '{$this->task->assign_to}'",
        ];
    }
}
