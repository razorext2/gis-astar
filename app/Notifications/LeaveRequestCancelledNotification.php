<?php

/** Goal: Notifikasi kepada backup person bahwa pengajuan cuti dibatalkan oleh pemohon, Caller: LeaveRequestService::processAction, Deps: LeaveRequest, WebPush */

namespace App\Notifications;

use App\Models\LeaveRequest\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class LeaveRequestCancelledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public LeaveRequest $leaveRequest
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', WebPushChannel::class];
    }

    public function toDatabase(object $notifiable): array
    {
        $requesterName = $this->leaveRequest->user->name;
        $leaveType = $this->leaveRequest->leaveType->name;
        $startDate = Carbon::parse($this->leaveRequest->start_date)->locale('id')->isoFormat('D MMM YYYY');
        $endDate = Carbon::parse($this->leaveRequest->end_date)->locale('id')->isoFormat('D MMM YYYY');

        return [
            'message' => "Pengajuan {$leaveType} dari {$requesterName} ({$startDate} s/d {$endDate}) telah dibatalkan oleh pemohon.",
            'button' => [
                'url' => url('/dashboard/leave-request/approval-center'),
                'label' => 'Pusat Approval',
            ],
            'created_at' => Carbon::now()->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss'),
        ];
    }

    public function toWebPush($notifiable, $notification): WebPushMessage
    {
        $requesterName = $this->leaveRequest->user->name;
        $leaveType = $this->leaveRequest->leaveType->name;

        return (new WebPushMessage)
            ->title('Pengajuan Cuti Dibatalkan')
            ->body("Pengajuan {$leaveType} dari {$requesterName} telah dibatalkan.")
            ->icon(asset('/assets/img/logo.ico'))
            ->badge(asset('/assets/img/logo.ico'))
            ->action('Pusat Approval', url('/dashboard/leave-request/approval-center'))
            ->tag('LeaveRequestCancelled')
            ->data([
                'url' => url('/dashboard/leave-request/approval-center'),
            ]);
    }
}
