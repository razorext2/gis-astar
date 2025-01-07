<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\CollectTask;

class CollectorTaskAssign extends Notification
{
    use Queueable;

    protected $collectorTask;
    /**
     * Create a new notification instance.
     */
    public function __construct(CollectTask $collectTask)
    {
        $this->collectorTask = $collectTask;
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
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //         ->line('The introduction to the notification.')
    //         ->action('Notification Action', url('/'))
    //         ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'no_sr' => $this->collectorTask->no_sr,
            'created_at' => $this->collectorTask->created_at,
            'message' => "Ada tagihan baru dengan kode '{$this->collectorTask->no_sr}' yang harus kamu tagih!",
        ];
    }
}
