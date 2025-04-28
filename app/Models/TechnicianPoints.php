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
        'redeemed_status', // 0 = validation, 1 = confirmation, 2 = approval hrd, 3 = acc, 4 = ditolak
        'redeemed_date',
        'transaction_id',
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function kunjungan(): BelongsTo
    {
        return $this->belongsTo(Technician::class, 'from_vt', 'no_vt');
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(PointTransactions::class, 'transaction_id', 'transaction_id');
    }
}
