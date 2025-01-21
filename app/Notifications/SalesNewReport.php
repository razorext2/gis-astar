<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SalesNewReport extends Notification
{
    use Queueable;

    protected $report_id;
    protected $created_at;
    /**
     * Create a new notification instance.
     */
    public function __construct($report_id, $created_at)
    {
        $this->report_id = $report_id;
        $this->created_at = $created_at;
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
        $date = $this->created_at->locale('id')->isoFormat('DD MMMM YYYY');

        return [
            'message' => "Sales telah membuat laporan baru pada tanggal $date, silahkan diperiksa dan lakukan konfirmasi.",
            "button" => [
                "url" => route('sales.show', $this->report_id),
                "label" => "Periksa Laporan",
            ],
            "created_at" => Carbon::now()->locale("id")->isoFormat("DD MMM YYYY HH:mm:ss"),

        ];
    }
}
