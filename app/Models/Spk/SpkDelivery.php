<?php

namespace App\Models\Spk;

use Illuminate\Database\Eloquent\Model;

class SpkDelivery extends Model
{
    protected $table = 'tb_spk_delivery';

    protected $fillable = [
        'id_spk',
        'nomor_sr',
        'via',
        'partay',
        'no_container',
        'nama_kapal',
        'no_plat',
        'nama_supir',
        'id_supir',
        'no_telp_supir',
        'berat',
        'etd',
        'eta',
        'note',
        'products',
        'is_delay',
        'history',
    ];

    protected $casts = [
        'products' => 'array',
        'is_delay' => 'array',
        'history' => 'array',
    ];

    public function spk()
    {
        return $this->belongsTo(SpkMain::class, 'id_spk', 'id');
    }

    public function supir()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_supir', 'id');
    }
}
