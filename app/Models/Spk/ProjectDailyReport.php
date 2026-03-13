<?php

namespace App\Models\Spk;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectDailyReport extends Model
{
    use HasUlids, SoftDeletes;

    protected $table = 'tb_spk_project_daily_reports';

    protected $fillable = [
        'assignment_id',
        'report_date',
        'status',
        'submitted_at',
    ];

    public function assignment()
    {
        return $this->belongsTo(ProjectAssignment::class, 'assignment_id', 'id');
    }

    public function hourlyReport()
    {
        return $this->hasMany(ProjectHourlyReport::class, 'daily_report_id', 'id');
    }
}
