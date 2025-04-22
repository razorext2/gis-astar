<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TechnicianPoints extends Model
{
    use SoftDeletes;
    protected $table = 'tb_technician_points';
    protected $fillable = [
        'from_vt',
        'point',
        'kode_pegawai',
        'is_redeemable',
        'is_redeemed',
        'redeemed_status', // 0 = validation, 1 = confirmation, 2 = approval hrd, 3 = approval management, 4 = ditolak
        'redeemed_date',
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function kunjungan(): BelongsTo
    {
        return $this->belongsTo(Technician::class, 'from_vt', 'no_vt');
    }
}
