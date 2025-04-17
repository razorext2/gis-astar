<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhotoCollect extends Model
{
    use HasFactory;
    protected $table = 'tb_photo_collect';
    protected $fillable = ['id_collect', 'id_sales', 'id_driver', 'no_vt', 'photourl'];

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

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'id_driver');
    }

    public function teknisi()
    {
        return $this->belongsTo(Technician::class, 'no_vt', 'no_vt');
    }
}
