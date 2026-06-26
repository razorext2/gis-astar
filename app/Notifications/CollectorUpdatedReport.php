<?php
 
/** Goal: Notify users with permission collect-approve when collector updates report, Caller: NotifyCollectorHasUpdatedReportJob, Deps: WebPush, Database */
 
namespace App\Notifications;

use App\Support\IdObfuscator;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class CollectorUpdatedReport extends Notification implements ShouldQueue
{
    use Queueable;

    protected $no_sr;
    protected $collect_id;
    protected $date;

    /**
     * Create a new notification instance.
     */
    public function __construct($no_sr, $collect_id, $date)
    {
        $this->no_sr = $no_sr;
        $this->collect_id = $collect_id;
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
        $date = Carbon::parse($this->date)->locale("id")->isoFormat("DD MMMM YYYY");

        return [
            "message" => "Laporan dengan kode: $this->no_sr telah diperbarui pada tanggal $date. Silahkan diperiksa!",
            "button" => [
                'url' => route('collect.show', IdObfuscator::encode($this->collect_id)),
                'label' => 'Periksa Laporan',
            ],
            "created_at" => Carbon::now()->locale("id")->isoFormat("DD MMM YYYY HH:mm:ss"),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title("PT. Indodacin Presisi Utama")
            ->body("Laporan dengan kode: $this->no_sr telah diperbarui pada tanggal $this->date. Silahkan diperiksa!")
            ->icon(asset("/assets/img/logo.ico"))
            ->badge(asset("/assets/img/logo.ico"))
            ->action("Periksa Laporan", route("collect.show", IdObfuscator::encode($this->collect_id)))
            ->tag("Indodacin")
            ->data([
                "url" => route("collect.show", IdObfuscator::encode($this->collect_id)),
            ]);
    }
}
