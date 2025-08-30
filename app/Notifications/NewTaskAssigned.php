<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class NewTaskAssigned extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user_id;
    protected $collect_id;
    protected $no_sr;

    /**
     * Create a new notification instance.
     */
    public function __construct($user_id, $collect_id, $no_sr)
    {
        $this->user_id = $user_id;
        $this->collect_id = $collect_id;
        $this->no_sr = $no_sr;
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

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            "message" => "Anda memiliki tagihan baru dengan kode tagihan: $this->no_sr yang harus anda tagih. Cek detail:",
            "button" => [
                "url" => route("collect.show", $this->collect_id),
                "label" => "Lihat Detail"
            ],
            "created_at" => Carbon::now()->locale("id")->isoFormat("DD MMM YYYY HH:mm:ss"),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title("PT. Indodacin Presisi Utama")
            ->body("Anda memiliki penagihan baru dengan kode tagihan: $this->no_sr yang harus anda tagih. Cek detail:")
            ->icon(asset("/assets/img/logo.ico"))
            ->badge(asset("/assets/img/logo.ico"))
            ->action("Lihat Detail", route("collect.show", $this->collect_id))
            ->tag("Indodacin")
            ->data([
                "url" => route("collect.show", $this->collect_id),
            ]);
    }
}
