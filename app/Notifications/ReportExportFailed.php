<?php

/** Goal: Notification untuk laporan export gagal, Caller: ExportReportJob::failed(), Deps: WebPushChannel */

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class ReportExportFailed extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
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
            'message' => "Proses ekspor Laporan {$this->reportLabel} gagal. Periode {$from} s/d {$to}. Silahkan coba kembali atau hubungi administrator.",
            'created_at' => now()->toDateTimeString(),
        ];
    }

    public function toWebPush(object $notifiable, $notification): WebPushMessage
    {
        $from = Carbon::parse($this->fromDate)->locale('id')->isoFormat('DD MMM YYYY');
        $to = Carbon::parse($this->toDate)->locale('id')->isoFormat('DD MMM YYYY');

        return (new WebPushMessage)
            ->title('PT. Indodacin Presisi Utama')
            ->body("Ekspor Laporan {$this->reportLabel} ({$from} - {$to}) gagal. Silahkan coba kembali.")
            ->icon(asset('assets/img/logo.ico'))
            ->badge(asset('assets/img/logo.ico'))
            ->tag('Indodacin');
    }
}
