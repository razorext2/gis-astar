<?php

/** Goal: Notifikasi database + push ketika export invoice selesai, Caller: ExportInvoiceToExcelJob, Deps: WebPush */

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class ExportInvoiceCompleted extends Notification implements ShouldQueue
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
        return ['database', WebPushChannel::class];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => "Proses ekspor telah selesai. Laporan invoice dari tanggal $this->fromDate sampai $this->toDate telah berhasil diekspor. Silahkan download berkas dengan klik tombol berikut.",
            'button' => [
                'url' => route('export.invoice.download', $this->fileName),
                'label' => 'Download Laporan',
            ],
            'created_at' => now()->toDateTimeString(),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('PT. Indodacin Presisi Utama')
            ->body("Proses ekspor telah selesai. Laporan invoice dari tanggal $this->fromDate sampai $this->toDate telah berhasil diekspor. Silahkan download berkas dengan klik tombol berikut.")
            ->icon(asset('/assets/img/logo.ico'))
            ->badge(asset('/assets/img/logo.ico'))
            ->action('Download Laporan', route('export.invoice.download', $this->fileName))
            ->tag('Indodacin')
            ->data([
                'url' => route('export.invoice.download', $this->fileName),
            ]);
    }
}
