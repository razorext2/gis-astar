<?php

namespace App\Notifications;

use App\Models\LeaveRequest\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class LeaveRequestApprovalNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public LeaveRequest $leaveRequest,
        public string $status
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', WebPushChannel::class];
    }

    public function toDatabase(object $notifiable): array
    {
        $requesterName = $this->leaveRequest->user->name;
        $type = $this->leaveRequest->leaveType->name;
        $msg = "Permohonan $type dari $requesterName menunggu persetujuan Anda.";

        return [
            'message' => $msg,
            'button' => [
                'url' => url("/dashboard/leave-request/approval-center/{$this->leaveRequest->id}"),
                'label' => 'Lihat Detail',
            ],
            'created_at' => Carbon::now()->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss'),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        $requesterName = $this->leaveRequest->user->name;
        $type = $this->leaveRequest->leaveType->name;

        return (new WebPushMessage)
            ->title('Persetujuan Cuti Baru')
            ->body("Permohonan $type dari $requesterName menunggu persetujuan Anda.")
            ->icon(asset('/assets/img/logo.ico'))
            ->badge(asset('/assets/img/logo.ico'))
            ->action('Lihat Detail', url("/dashboard/leave-request/approval-center/{$this->leaveRequest->id}"))
            ->tag('LeaveRequest')
            ->data([
                'url' => url("/dashboard/leave-request/approval-center/{$this->leaveRequest->id}"),
            ]);
    }
}
