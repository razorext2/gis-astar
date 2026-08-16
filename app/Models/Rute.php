<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Rute extends Model
{
    use SoftDeletes;

    protected $table = 'rute';

    protected $primaryKey = 'id_rute';

    protected $fillable = [
        'nama_rute',
        'jarak_total',
        'waktu_total',
        'algoritma',
    ];

    protected function casts(): array
    {
        return [
            'jarak_total' => 'float',
            'waktu_total' => 'integer',
        ];
    }

    /** Semua titik waypoint rute */
    public function titikRute(): HasMany
    {
        return $this->hasMany(TitikRute::class, 'id_rute', 'id_rute');
    }

    /** Detail rujukan yang menggunakan rute ini */
    public function detailRujukan(): HasOne
    {
        return $this->hasOne(DetailRujukan::class, 'id_rute', 'id_rute');
    }

    /** Ambil titik rute terurut berdasarkan urutan */
    public function getTitikTerurut(): Collection
    {
        return $this->titikRute()->orderBy('urutan')->get();
    }
}
