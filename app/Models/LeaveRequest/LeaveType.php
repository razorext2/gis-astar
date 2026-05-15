<?php

namespace App\Models\LeaveRequest;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $table = 'tb_leave_types';

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'code',
        'is_anual_deduction',
        'default_days',
        'requires_attachment',
    ];

    protected $casts = [
        'is_anual_deduction' => 'boolean',
        'default_days' => 'integer',
        'requires_attachment' => 'boolean',
    ];

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
}
