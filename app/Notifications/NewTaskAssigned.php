<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewTaskAssigned extends Notification
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
            "message" => "Anda memiliki tagihan baru dengan kode tagihan: $this->no_sr yang harus anda tagih. Cek detail:",
            "button" => [
                "url" => route("collect.show", $this->collect_id),
                "label" => "Lihat Detail"
            ],
            "created_at" => Carbon::now()->locale("id")->isoFormat("DD MMM YYYY HH:mm:ss"),
        ];
    }
}
