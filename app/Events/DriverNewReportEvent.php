<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DriverNewReportEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $created_at;

    protected $user_id;

    /**
     * Create a new event instance.
     */
    public function __construct($created_at, $user_id)
    {
        $this->created_at = $created_at instanceof Carbon ? $created_at : Carbon::parse($created_at);
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
        return 'driverNewReport';
    }

    public function broadcastWith()
    {
        $date = now();

        return [
            'message' => "Driver telah membuat laporan baru pada tanggal $date, silahkan diperiksa dan lakukan konfirmasi.",
        ];
    }
}
