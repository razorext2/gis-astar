<?php

namespace App\Models\Spk;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackingList extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'tb_packing_list';

    protected $fillable = [
        'id_barang',
        'nama_part',
        'jumlah',
        'satuan',
        'pack',
    ];
}
