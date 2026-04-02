<?php

namespace App\Models\Spk;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasUlids, SoftDeletes;

    protected $table = 'tb_spk_projects';

    protected $fillable = [
        'spk_id',
        'start_date',
        'end_date',
        'deadline',
        'project_name',
        'customer_name',
        'extend_request',
        'extend_to',
        'extend_request_by',
        'extend_request_at',
        'extend_request_notes',
        'extend_request_status',
        'extend_request_validated_at',
        'extend_request_validated_notes',
        'extend_request_validated_by',
        'description',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'deadline' => 'date',
        'extend_to' => 'date',
        'extend_request' => 'boolean',
    ];

    public function spk()
    {
        return $this->belongsTo(SpkMain::class, 'spk_id', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function assignment()
    {
        return $this->hasMany(ProjectAssignment::class, 'project_id', 'id');
    }

    public function extendRequestBy()
    {
        return $this->belongsTo(User::class, 'extend_request_by', 'id');
    }

    public function extendRequestValidatedBy()
    {
        return $this->belongsTo(User::class, 'extend_request_validated_by', 'id');
    }
}
