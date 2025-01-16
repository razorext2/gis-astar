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
        $date = Carbon::parse($this->date)->locale("id")->isoFormat("DD MMMM YYYY");

        return [
            "message" => "Laporan dengan kode: $this->no_sr telah diperbarui pada tanggal $date. Silahkan diperiksa!",
            "button" => [
                'url' => route('collect.show', $this->collect_id),
                'label' => 'Periksa Laporan',
            ],
            "created_at" => Carbon::now()->locale("id")->isoFormat("DD MMM YYYY HH:mm:ss"),
        ];
    }
}
