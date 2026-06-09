<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SalesNewReportEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $report_id;

    protected $notification_id;

    protected $created_at;

    protected $user_id;

    /**
     * Create a new event instance.
     */
    public function __construct($report_id, $notification_id, $created_at, $user_id)
    {
        $this->report_id = $report_id;
        $this->notification_id = $notification_id;
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
        return 'salesNewReport';
    }

    public function broadcastWith()
    {
        $date = $this->created_at->locale('id')->isoFormat('DD MMMM YYYY');

        return [
            'id' => $this->notification_id,
            'message' => "Sales telah membuat laporan baru pada tanggal $date, silahkan diperiksa dan lakukan konfirmasi.",
            'button' => [
                'url' => route('sales.show', $this->report_id),
                'label' => 'Periksa Laporan',
            ],
            'mark_as_read' => route('notification.mark-as-read', $this->notification_id),
            'created_at' => Carbon::now()->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss'),

        ];
    }
}
