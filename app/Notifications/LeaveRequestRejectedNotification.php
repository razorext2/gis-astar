<?php

/** Goal: Notifikasi kepada pemohon cuti bahwa pengajuannya telah ditolak, Caller: LeaveRequestService::processAction, Deps: LeaveRequest, WebPush */

namespace App\Notifications;

use App\Models\LeaveRequest\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class LeaveRequestRejectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public LeaveRequest $leaveRequest,
        public string $rejectedBy,
        public ?string $reason = null
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

        $msg = "Pengajuan {$leaveType} Anda ({$startDate} s/d {$endDate}) ditolak oleh {$this->rejectedBy}.";
        if ($this->reason) {
            $msg .= " Alasan: {$this->reason}";
        }

        return [
            'message' => $msg,
            'button' => [
                'url' => route('leave-request.my-requests.show', $this->leaveRequest->id),
                'label' => 'Lihat Detail',
            ],
            'created_at' => Carbon::now()->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss'),
        ];
    }

    public function toWebPush($notifiable, $notification): WebPushMessage
    {
        $leaveType = $this->leaveRequest->leaveType->name;

        return (new WebPushMessage)
            ->title('Pengajuan Cuti Ditolak ❌')
            ->body("Pengajuan {$leaveType} Anda ditolak oleh {$this->rejectedBy}.")
            ->icon(asset('/assets/img/logo.ico'))
            ->badge(asset('/assets/img/logo.ico'))
            ->action('Lihat Detail', route('leave-request.my-requests.show', $this->leaveRequest->id))
            ->tag('LeaveRequestRejected')
            ->data([
                'url' => route('leave-request.my-requests.show', $this->leaveRequest->id),
            ]);
    }
}
