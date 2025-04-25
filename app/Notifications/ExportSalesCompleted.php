<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExportSalesCompleted extends Notification
{
    use Queueable;

    protected $fileName;
    protected $fromDate;
    protected $toDate;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $fileName, $fromDate, $toDate)
    {
        $this->fileName = $fileName;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
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
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => "Proses ekspor telah selesai. Laporan sales dari tanggal $this->fromDate sampai $this->toDate telah berhasil diekspor. Silahkan download berkas dengan klik tombol berikut.",
            'button' => [
                'url' => route('export.sales.download', $this->fileName),
                'label' => 'Download Laporan',
            ],
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
