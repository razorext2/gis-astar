<?php

namespace App\Models\Spk;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchasingRequest extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'tb_purchasing_request';

    protected $fillable = [
        'id_spk',
        'nomor_purchasing_request',
        'kode_item',
        'nama_item',
        'qty',
        'satuan',
        'lokasi_gudang_terima',
        'jumlah_item_dipesan',
        'keterangan',
        'added_by',
    ];

    public function spk()
    {
        return $this->belongsTo(SpkMain::class, 'id_spk', 'id');
    }

    public function addedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'added_by', 'id');
    }
}
