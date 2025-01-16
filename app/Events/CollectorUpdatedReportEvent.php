<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CollectorUpdatedReportEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $notification_id;
    protected $no_sr;
    protected $user_id;
    protected $collect_id;
    protected $date;

    /**
     * Create a new event instance.
     */
    public function __construct($notification_id, $no_sr, $user_id, $collect_id, $date)
    {
        $this->notification_id = $notification_id;
        $this->no_sr = $no_sr;
        $this->user_id = $user_id;
        $this->collect_id = $collect_id;
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
            new PrivateChannel("notifications.$this->user_id"),
        ];
    }

    public function broadcastAs()
    {
        return 'collectorUpdatedReport';
    }

    public function broadcastWith()
    {
        $date = Carbon::parse($this->date)->locale("id")->isoFormat("DD MMMM YYYY");

        return [
            "id" => $this->notification_id,
            "message" => "Laporan dengan kode: $this->no_sr telah diperbarui pada tanggal: $date. Silahkan diperiksa!",
            "button" => [
                "url" => route("collect.show", $this->collect_id),
                "label" => "Periksa Laporan",
            ],
            "mark_as_read" => route("notification.mark-as-read", $this->notification_id),
            "created_at" => Carbon::now()->locale("id")->isoFormat("DD MMM YYYY HH:mm:ss"),
        ];
    }
}
