<?php

namespace App\Models\DataTimbang;

/** Goal: Represent TbDataTimbangIndodaya model, Caller: Database operations, Deps: none */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataTimbangIndodaya extends Model
{
    use SoftDeletes;

    protected $table = 'tb_data_timbang_indodaya';

    protected $fillable = [
        'no_seri',
        'no_polisi',
        'nm_relasi',
        'nm_barang',
        'nm_supir',
        'referensi',
        'timbang1',
        'timbang2',
        'potongan',
        'netto',
        'tanggal_m',
        'tanggal_k',
        'waktu1',
        'waktu2',
        'penimbang',
        'nama_perusahaan',
    ];

    protected function casts(): array
    {
        return [
            'timbang1' => 'float',
            'timbang2' => 'float',
            'potongan' => 'float',
            'netto' => 'float',
            'tanggal_m' => 'date',
            'tanggal_k' => 'date',
        ];
    }
}
