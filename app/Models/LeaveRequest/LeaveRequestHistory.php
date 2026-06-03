<?php

namespace App\Models\LeaveRequest;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class LeaveRequestHistory extends Model
{
    protected $table = 'tb_leave_request_histories';

    protected $guarded = ['id'];

    protected $fillable = [
        'leave_request_id',
        'acted_by',
        'action',
        'status_from',
        'status_to',
        'note',
    ];

    public function leaveRequest()
    {
        return $this->belongsTo(LeaveRequest::class, 'leave_request_id');
    }

    public function actedByUser()
    {
        return $this->belongsTo(User::class, 'acted_by');
    }

    public function getDescriptionAttribute()
    {
        return match ($this->action) {
            'submit' => 'Pengajuan diajukan',
            'approve' => 'Disetujui',
            'final_approve' => 'Cuti Disetujui Sepenuhnya',
            'reject' => 'Pengajuan Ditolak',
            'auto_reject' => 'Ditolak Otomatis (Expired)',
            'cancel' => 'Pengajuan Dibatalkan',
            'quota_deducted' => 'Kuota Cuti Dipotong',
            'quota_restored' => 'Kuota Cuti Dikembalikan',
            default => 'Status diperbarui'
        };
    }
}
