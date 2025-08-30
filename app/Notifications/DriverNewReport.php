<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class DriverNewReport extends Notification implements ShouldQueue
{
    use Queueable;

    protected $driver_id;
    protected $created_at;

    /**
     * Create a new notification instance.
     */
    public function __construct($driver_id, $created_at)
    {
        $this->driver_id = $driver_id;
        $this->created_at = $created_at;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', WebPushChannel::class];
    }

    public function toDatabase(object $notifiable): array
    {
        $date = $this->created_at->locale('id')->isoFormat('DD MMMM YYYY');

        return [
            'message' => "Driver telah membuat laporan baru pada tanggal $date, silahkan diperiksa dan lakukan konfirmasi.",
            "button" => [
                "url" => route('driver.show', $this->driver_id),
                "label" => "Periksa Laporan",
            ],
            "created_at" => Carbon::now()->locale("id")->isoFormat("DD MMM YYYY HH:mm:ss"),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title("PT. Indodacin Presisi Utama")
            ->body("Driver telah membuat laporan baru pada tanggal $this->created_at, silahkan diperiksa dan lakukan konfirmasi.")
            ->icon("https://indodacin.dev/assets/img/logo.ico")
            ->badge("https://indodacin.dev/assets/img/logo.ico")
            ->action("Periksa Laporan", route("driver.show", $this->driver_id))
            ->tag("Indodacin")
            ->data([
                "url" => route("driver.show", $this->driver_id),
            ]);
    }
}
