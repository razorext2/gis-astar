<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PhotoCollect extends Model
{
    use HasFactory;
    protected $table = 'tb_photo_collect';
    protected $fillable = ['id_collect', 'id_sales', 'photourl'];

    // karena nilai dari kolom id_collect diambil dari nilai id pada tb_collect
    // maka buat relasi belongsTo karena 1 data dari tabel ini hanya memiliki 1 data dari tb_collect
    public function collectRelasi()
    {
        return $this->belongsTo(Collector::class, 'id_collect');
    }

    public function salesRelasi()
    {
        return $this->belongsTo(Collector::class, 'id_sales');
    }
}
