<?php

namespace App\Models\Spk;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectAssignment extends Model
{
    use HasUlids, SoftDeletes;

    protected $table = 'tb_spk_project_assignments';

    protected $fillable = [
        'project_id',
        'laporan_type',
        'nomor_vt',
        'assign_to',
        'assign_at',
        'status',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function assignTo()
    {
        return $this->belongsTo(\App\Models\User::class, 'assign_to', 'id');
    }

    public function dailyReports()
    {
        return $this->hasMany(ProjectDailyReport::class, 'assignment_id', 'id');
    }
}
