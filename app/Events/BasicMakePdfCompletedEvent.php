<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BasicMakePdfCompletedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected ?string $notification_id;

    protected ?int $user_id;

    protected ?string $message;

    protected ?string $route;

    protected ?array $parameters;

    protected ?string $label;

    /**
     * Create a new event instance.
     */
    public function __construct($notification_id, $user_id, $message, $route, $parameters, $label)
    {
        $this->notification_id = $notification_id;
        $this->user_id = $user_id;
        $this->message = $message;
        $this->route = $route;
        $this->parameters = $parameters;
        $this->label = $label;
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
        return 'exportCompleted';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->notification_id,
            'message' => $this->message,
            'button' => [
                'url' => route($this->route, $this->parameters),
                'label' => $this->label,
            ],
            'mark_as_read' => route('notification.mark-as-read', $this->notification_id),
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
