<?php

/** Goal: Notifikasi kepada pemohon cuti bahwa pengajuannya telah disetujui sepenuhnya, Caller: LeaveRequestService::processAction, Deps: LeaveRequest, WebPush */

namespace App\Notifications;

use App\Models\LeaveRequest\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class LeaveRequestApprovedNotification extends Notification implements ShouldQueue
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
        $leaveType = $this->leaveRequest->leaveType->name;
        $startDate = Carbon::parse($this->leaveRequest->start_date)->locale('id')->isoFormat('D MMM YYYY');
        $endDate = Carbon::parse($this->leaveRequest->end_date)->locale('id')->isoFormat('D MMM YYYY');

        return [
            'message' => "Pengajuan {$leaveType} Anda ({$startDate} s/d {$endDate}) telah disetujui sepenuhnya. Selamat menikmati cuti!",
            'button' => [
                'url' => url("/dashboard/leave-request/my-requests/{$this->leaveRequest->id}"),
                'label' => 'Lihat Detail',
            ],
            'created_at' => Carbon::now()->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss'),
        ];
    }

    public function toWebPush($notifiable, $notification): WebPushMessage
    {
        $leaveType = $this->leaveRequest->leaveType->name;
        $startDate = Carbon::parse($this->leaveRequest->start_date)->locale('id')->isoFormat('D MMM YYYY');
        $endDate = Carbon::parse($this->leaveRequest->end_date)->locale('id')->isoFormat('D MMM YYYY');

        return (new WebPushMessage)
            ->title('Cuti Disetujui! ✅')
            ->body("Pengajuan {$leaveType} Anda ({$startDate} s/d {$endDate}) telah disetujui sepenuhnya.")
            ->icon(asset('/assets/img/logo.ico'))
            ->badge(asset('/assets/img/logo.ico'))
            ->action('Lihat Detail', url("/dashboard/leave-request/my-requests/{$this->leaveRequest->id}"))
            ->tag('LeaveRequestApproved')
            ->data([
                'url' => url("/dashboard/leave-request/my-requests/{$this->leaveRequest->id}"),
            ]);
    }
}
