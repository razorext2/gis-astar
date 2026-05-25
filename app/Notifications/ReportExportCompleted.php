<?php

/** Goal: Notification untuk laporan export selesai, Caller: ExportReportJob, Deps: WebPushChannel */

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class ReportExportCompleted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected string $fileName,
        protected string $reportLabel,
        protected string $fromDate,
        protected string $toDate,
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
        $from = Carbon::parse($this->fromDate)->locale('id')->isoFormat('DD MMMM YYYY');
        $to = Carbon::parse($this->toDate)->locale('id')->isoFormat('DD MMMM YYYY');

        return [
            'message' => "Proses ekspor Laporan {$this->reportLabel} telah selesai. Periode {$from} s/d {$to}. Silahkan download berkas dengan klik tombol berikut.",
            'button' => [
                'url' => route('export.report.download', $this->fileName),
                'label' => 'Download Laporan',
            ],
            'created_at' => now()->toDateTimeString(),
        ];
    }

    public function toWebPush(object $notifiable, $notification): WebPushMessage
    {
        $from = Carbon::parse($this->fromDate)->locale('id')->isoFormat('DD MMM YYYY');
        $to = Carbon::parse($this->toDate)->locale('id')->isoFormat('DD MMM YYYY');

        return (new WebPushMessage)
            ->title('PT. Indodacin Presisi Utama')
            ->body("Laporan {$this->reportLabel} ({$from} - {$to}) berhasil diekspor.")
            ->icon(asset('assets/img/logo.ico'))
            ->badge(asset('assets/img/logo.ico'))
            ->action('Download Laporan', route('export.report.download', $this->fileName))
            ->tag('Indodacin')
            ->data([
                'url' => route('export.report.download', $this->fileName),
            ]);
    }
}
