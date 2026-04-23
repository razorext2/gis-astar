<?php

namespace App\Models\LeaveRequest;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class LeaveBalance extends Model
{
    protected $table = 'tb_leave_balances';

    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'year',
        'total_quota',
        'used_quota',
    ];

    protected $casts = [
        'total_quota' => 'integer',
        'used_quota' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getRemainingQuotaAttribute()
    {
        return $this->total_quota - $this->used_quota;
    }
}
