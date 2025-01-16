<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ExportCompleted extends Notification
{
    use Queueable;

    protected $fileName;
    protected $date;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $fileName, $date)
    {
        $this->fileName = $fileName;
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
            'message' => "Proses ekspor telah selesai. Laporan penagihan untuk tanggal $this->date telah berhasil diekspor. Silahkan download berkas dengan klik tombol berikut.",
            'url' => $this->fileName,
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
