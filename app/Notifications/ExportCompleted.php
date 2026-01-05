<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class ExportCompleted extends Notification implements ShouldQueue
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
        return ['database', WebPushChannel::class];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        $date = Carbon::parse($this->date)->locale('id')->isoFormat('DD MMMM YYYY');

        return [
            'message' => "Proses ekspor telah selesai. Laporan untuk tanggal $date telah berhasil diekspor. Silahkan download berkas dengan klik tombol berikut.",
            'button' => [
                'url' => route('export.collector.download', $this->fileName),
                'label' => 'Download Laporan',
            ],
            'created_at' => now()->toDateTimeString(),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('PT. Indodacin Presisi Utama')
            ->body("Proses ekspor telah selesai. Laporan untuk tanggal $this->date telah berhasil diekspor. Silahkan download berkas dengan klik tombol berikut.")
            ->icon(asset('assets/img/logo.ico'))
            ->badge(asset('assets/img/logo.ico'))
            ->action('Download Laporan', route('export.collector.download', $this->fileName))
            ->tag('Indodacin')
            ->data([
                'url' => route('export.collector.download', $this->fileName),
            ]);
    }
}
