<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PointTransactions extends Model
{
    use SoftDeletes;

    protected $table = 'tb_point_transactions';

    protected $fillable = [
        'transaction_id',
        'quartal',
        'year',
        'point_type',
        'kode_pegawai',
        'redeemed_by',
        'from_date',
        'to_date',
        'valid_points',
        'invalid_points',
        'total_points',
        'status', // 0 = validation, 1 = confirmation, 2 = approval hrd, 3 = acc, 4 = ditolak
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function redeemedby()
    {
        return $this->belongsTo(User::class, 'redeemed_by', 'id');
    }

    public function point(): HasMany
    {
        $fromDate = $this->from_date;
        $toDate = $this->to_date;

        return $this->hasMany(TechnicianPoints::class, 'kode_pegawai', 'kode_pegawai')
            ->join('tb_technician', 'tb_technician.no_vt', '=', 'tb_technician_points.from_vt')
            ->whereBetween('tb_technician_points.created_at', [$fromDate, $toDate])
            ->where('tb_technician_points.is_redeemable', 1)
            ->select([
                'tb_technician_points.*',
                'tb_technician.customer_contact',
                'tb_technician.visit_date',
            ]);
    }
}
