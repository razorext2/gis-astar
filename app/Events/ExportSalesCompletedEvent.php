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

class ExportSalesCompletedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $notifID;
    protected $userID;
    protected $filename;
    protected $fromDate;
    protected $toDate;

    /**
     * Create a new event instance.
     */
    public function __construct($notifID, $userID, $filename, $fromDate, $toDate)
    {
        $this->notifID = $notifID;
        $this->userID = $userID;
        $this->filename = $filename;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("notifications.$this->userID"),
        ];
    }

    public function broadcastAs()
    {
        return "exportCompleted";
    }

    public function broadcastWith(): array
    {
        return [
            "id" => $this->notifID,
            "message" => "Proses ekspor telah selesai. Laporan sales untuk tanggal $this->fromDate - $this->toDate telah berhasil diekspor. Silahkan download berkas dengan klik tombol berikut.",
            "button" => [
                "url" => route("export.sales.download", $this->filename),
                "label" => "Download Laporan",
            ],
            "mark_as_read" => route("notification.mark-as-read", $this->notifID),
            "created_at" => Carbon::now()->locale("id")->isoFormat("DD MMM YYYY HH:mm:ss"),
        ];
    }
}
