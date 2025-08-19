<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendNotifAttendance extends Notification
{
    use Queueable;

    protected $data_id;
    protected $message;
    protected $type;

    /**
     * Create a new notification instance.
     */
    public function __construct($message, $data_id, $type)
    {
        $this->message = $message;
        $this->data_id = $data_id;
        $this->type = $type;
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
        $routes = [
            'AttendanceIn' => 'attendanceIn',
            'AttendanceOut' => 'attendanceOut',
        ];

        $route = $routes[$this->type] ?? 'attendance';

        return [
            'message' => $this->message,
            "button" => [
                "url" => route("{$route}.index", $this->data_id),
                "label" => "Periksa",
            ],
            "created_at" => now(),

        ];
    }
}
