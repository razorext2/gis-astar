<?php

/** Goal: Notifikasi database + push ketika export poin teknisi selesai, Caller: CreatePointTechnicianTransactionExcelJob, Deps: WebPush */

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class ExportPointTransactionCompleted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected string $fileName,
        protected string $quartal,
        protected string $year
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', WebPushChannel::class];
    }

    /**
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => "Proses ekspor poin teknisi Q{$this->quartal} {$this->year} telah selesai. Silahkan download berkas dengan klik tombol berikut.",
            'button' => [
                'url' => route('export.point.download', $this->fileName),
                'label' => 'Download Laporan',
            ],
            'created_at' => now()->toDateTimeString(),
        ];
    }

    public function toWebPush(object $notifiable, object $notification): WebPushMessage
    {
        return (new WebPushMessage)
            ->title('PT. Indodacin Presisi Utama')
            ->body("Proses ekspor poin teknisi Q{$this->quartal} {$this->year} telah selesai. Silahkan download berkas.")
            ->icon(asset('/assets/img/logo.ico'))
            ->badge(asset('/assets/img/logo.ico'))
            ->action('Download Laporan', route('export.point.download', $this->fileName))
            ->tag('Indodacin')
            ->data([
                'url' => route('export.point.download', $this->fileName),
            ]);
    }
}
