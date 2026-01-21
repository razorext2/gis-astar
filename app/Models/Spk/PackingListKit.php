<?php

namespace App\Models\Spk;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PackingListKit extends Model
{
    use HasUuids;

    protected $table = 'tb_packing_list_kit';

    protected $fillable = [
        'id_spk',
        'id_barang_produksi',
        'nama_customer',
        'nama_kit',
        'jumlah_kit',
        'satuan_kit',
        'peti',
    ];

    protected $casts = [
        'peti' => 'array',
    ];

    public function spk()
    {
        return $this->belongsTo(SpkMain::class, 'id_spk', 'id');
    }
}
