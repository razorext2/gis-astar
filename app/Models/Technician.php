<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Technician extends Model
{
    use SoftDeletes;

    protected $table = 'tb_technician';

    protected $fillable = [
        'no_vt',
        'id_permintaan',
        'kode_pegawai',
        'customer_contact',
        'customer_address',
        'job_detail',
        'weight_type',
        'size',
        'capacity',
        'indicator_type',
        'indicator_sn',
        'loadcell_type',
        'loadcell_qty',
        'loadcell_sn',
        'junction_type',
        'job_update',
        'visit_date',
        'status',
        'validate_by',
        'validate_at',
        'total_revision',
        'notes',
        'revised_by',
        'revised_at',
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validate_by', 'id');
    }

    public function revised_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revised_by', 'id');
    }

    public function technician_points(): BelongsTo
    {
        return $this->belongsTo(TechnicianPoints::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function point(): BelongsTo
    {
        return $this->belongsTo(TechnicianPoints::class, 'no_vt', 'from_vt');
    }

    public function photo_collects(): HasMany
    {
        return $this->hasMany(PhotoCollect::class, 'no_vt', 'no_vt');
    }

    public function scopeNeedApprove($query)
    {
        return $query->where('status', 0);
    }
}
