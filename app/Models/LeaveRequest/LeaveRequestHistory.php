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
        'status_to',
        'note',
    ];

    public function leaveRequest()
    {
        return $this->belongsTo(LeaveRequest::class, 'leave_request_id');
    }

    public function actedBy()
    {
        return $this->belongsTo(User::class, 'acted_by');
    }
}
