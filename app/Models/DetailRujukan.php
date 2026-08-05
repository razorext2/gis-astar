<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailRujukan extends Model
{
    protected $table = 'detail_rujukan';

    protected $primaryKey = 'id_detail';

    protected $fillable = [
        'id_rujukan',
        'id_rute',
        'jarak',
        'waktu_tempuh',
        'estimasi_biaya',
        'metode',
    ];

    protected function casts(): array
    {
        return [
            'jarak' => 'float',
            'waktu_tempuh' => 'integer',
            'estimasi_biaya' => 'float',
        ];
    }

    public function rujukan(): BelongsTo
    {
        return $this->belongsTo(Rujukan::class, 'id_rujukan', 'id_rujukan');
    }

    public function rute(): BelongsTo
    {
        return $this->belongsTo(Rute::class, 'id_rute', 'id_rute');
    }
}
