<?php

namespace App\Models\Spk;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class ProjectHourlyReportFile extends Model
{
    use HasUlids;

    protected $table = 'tb_spk_project_hourly_report_files';

    protected $fillable = [
        'hourly_report_id',
        'file_path',
        'file_type',
    ];

    public function hourlyReport()
    {
        return $this->belongsTo(ProjectHourlyReport::class, 'hourly_report_id', 'id');
    }
}
