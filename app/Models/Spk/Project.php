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
        'description',
        'created_by',
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
}
