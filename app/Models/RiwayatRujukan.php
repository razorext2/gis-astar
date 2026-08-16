<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatRujukan extends Model
{
    use SoftDeletes;

    protected $table = 'riwayat_rujukan';

    protected $primaryKey = 'id_riwayat';

    public $timestamps = false;

    protected $fillable = [
        'id_rujukan',
        'status_lama',
        'status_baru',
        'keterangan',
        'diubah_oleh',
        'waktu_perubahan',
    ];

    protected function casts(): array
    {
        return [
            'waktu_perubahan' => 'datetime',
        ];
    }

    public function rujukan(): BelongsTo
    {
        return $this->belongsTo(Rujukan::class, 'id_rujukan', 'id_rujukan')->withTrashed();
    }

    /** User yang mengubah status */
    public function diubahOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diubah_oleh');
    }
}
