<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CollectorUpdatedReport extends Notification
{
    use Queueable;

    protected $no_sr;
    protected $collect_id;
    protected $date;

    /**
     * Create a new notification instance.
     */
    public function __construct($no_sr, $collect_id, $date)
    {
        $this->no_sr = $no_sr;
        $this->collect_id = $collect_id;
        $this->date = $date;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            "message" => "Laporan dengan kode tagihan: $this->no_sr telah diperbarui pada tanggal: $this->date. Silahkan diperiksa!",
            "url" => route("collect.show", $this->collect_id),
            "created_at" => Carbon::now()->locale("id")->isoFormat("DD MMM YYYY HH:mm:ss"),
        ];
    }
}
