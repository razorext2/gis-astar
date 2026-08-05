<?php

namespace App\Models;

use App\Enums\TipeTitikRute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TitikRute extends Model
{
    protected $table = 'titik_rute';

    protected $primaryKey = 'id_titik';

    protected $fillable = [
        'id_rute',
        'urutan',
        'nama_lokasi',
        'latitude',
        'longitude',
        'tipe',
    ];

    protected function casts(): array
    {
        return [
            'tipe' => TipeTitikRute::class,
            'latitude' => 'float',
            'longitude' => 'float',
            'urutan' => 'integer',
        ];
    }

    public function rute(): BelongsTo
    {
        return $this->belongsTo(Rute::class, 'id_rute', 'id_rute');
    }
}
