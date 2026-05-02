<?php

namespace App\Models\LeaveRequest;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $table = 'tb_leave_requests';

    protected $guarded = ['id'];

    // Transient properties for Observer
    public $current_note;

    public $acted_by;

    protected $fillable = [
        'user_id',
        'leave_type_id',
        'backup_person_id',
        'start_date',
        'end_date',
        'return_date',
        'total_days',
        'reason',
        'attachments',
        'status',
        'is_borrowed',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'return_date' => 'date',
        'total_days' => 'integer',
        'attachments' => 'array',
        'is_borrowed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }

    public function backupPerson()
    {
        return $this->belongsTo(User::class, 'backup_person_id');
    }

    public function histories()
    {
        return $this->hasMany(LeaveRequestHistory::class, 'leave_request_id')->orderBy('created_at', 'asc');
    }
}
