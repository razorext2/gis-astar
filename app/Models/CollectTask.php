<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectTask extends Model
{
    protected $table = "tb_collect_tasks";
    protected $fillable = [
        'no_sr',
        'sr_type',
        'sr_date',
        'customer_name',
        'customer_recipient',
        'customer_address',
        'customer_telp',
        'customer_fax',
        'shipping_address',
        'total_bil',
        'assign_by',
        'assign_to',
        'assign_date'
    ];

    public function pegawaiRelasi()
    {
        return $this->belongsTo(Pegawai::class, 'kode_pegawai', 'assign_to');
    }
}
