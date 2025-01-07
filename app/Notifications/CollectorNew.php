<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\CollectorTask;

class CollectorNew extends Notification
{
    use Queueable;

    protected $collector;

    /**
     * Create a new notification instance.
     */
    public function __construct(Collector $collector)
    {
        $this->collector = $collector;
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
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable)
    {
        return [
            'no_sr' => $this->collector->no_sr,
            'created_at' => $this->collector->created_at,
            'message' => "Ada tagihan baru dengan kode '{$this->collector->no_sr} yang harus anda tagih!'"
        ];
    }
}
