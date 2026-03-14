<?php

namespace App\Models\Spk;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ProjectHourlyReport extends Model
{
    use HasUlids, SoftDeletes;

    protected $table = 'tb_spk_project_hourly_reports';

    protected $fillable = [
        'daily_report_id',
        'start_time',
        'end_time',
        'activity',
        'location',
        'notes',
    ];

    protected static function booted()
    {
        static::deleting(function ($report) {

            foreach ($report->files as $file) {

                if (Storage::exists($file->file_path)) {
                    Storage::delete($file->file_path);
                }

                $file->delete();
            }

        });
    }

    public function dailyReport()
    {
        return $this->belongsTo(ProjectDailyReport::class, 'daily_report_id', 'id');
    }

    public function files()
    {
        return $this->hasMany(ProjectHourlyReportFile::class, 'hourly_report_id', 'id');
    }
}
