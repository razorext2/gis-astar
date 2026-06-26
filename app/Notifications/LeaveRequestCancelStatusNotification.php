<?php

namespace App\Notifications;

use App\Models\LeaveRequest\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class LeaveRequestCancelStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public LeaveRequest $leaveRequest,
        public string $status // 'approved' or 'rejected'
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', WebPushChannel::class];
    }

    public function toDatabase(object $notifiable): array
    {
        $leaveType = $this->leaveRequest->leaveType->name;
        $statusText = $this->status === 'approved' ? 'telah disetujui' : 'ditolak';

        return [
            'message' => "Permintaan pembatalan {$leaveType} Anda {$statusText}.",
            'button' => [
                'url' => route('leave-request.my-requests.show', $this->leaveRequest->id),
                'label' => 'Lihat Detail',
            ],
            'created_at' => Carbon::now()->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss'),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        $leaveType = $this->leaveRequest->leaveType->name;
        $statusText = $this->status === 'approved' ? 'Disetujui! ✅' : 'Ditolak ❌';

        return (new WebPushMessage)
            ->title("Pembatalan Cuti $statusText")
            ->body("Permintaan pembatalan {$leaveType} Anda telah " . ($this->status === 'approved' ? 'disetujui.' : 'ditolak.'))
            ->icon(asset('/assets/img/logo.ico'))
            ->badge(asset('/assets/img/logo.ico'))
            ->action('Lihat Detail', route('leave-request.my-requests.show', $this->leaveRequest->id))
            ->tag('LeaveRequestCancelStatus')
            ->data([
                'url' => route('leave-request.my-requests.show', $this->leaveRequest->id),
            ]);
    }
}
