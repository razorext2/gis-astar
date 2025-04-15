<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
        'status'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function redeemed_by()
    {
        return $this->belongsTo(User::class, 'redeemed_by', 'id');
    }
}
