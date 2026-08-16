<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RumahSakit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rumah_sakit_rujukan';

    protected $primaryKey = 'id_rumah_sakit';

    protected $fillable = [
        'nama_rumah_sakit',
        'alamat',
        'no_telepon',
        'latitude',
        'longitude',
        'layanan_operasi',
    ];

    protected function casts(): array
    {
        return [
            'layanan_operasi' => 'array', // JSON array: ["ICU","IGD","Bedah"]
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    /** Daftar rujukan yang diarahkan ke RS ini */
    public function rujukan(): HasMany
    {
        return $this->hasMany(Rujukan::class, 'id_rumah_sakit', 'id_rumah_sakit');
    }

    public function getLayananListAttribute(): array
    {
        $val = $this->layanan_operasi;
        if (is_array($val)) {
            return $val;
        }
        if (is_string($val)) {
            $decoded = json_decode($val, true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        return [];
    }

    /**
     * Scope: filter RS yang memiliki layanan tertentu.
     * Menggunakan MySQL JSON_CONTAINS untuk query efisien.
     */
    public function scopeHasLayanan(Builder $query, string $layanan): Builder
    {
        return $query->whereRaw(
            'JSON_CONTAINS(layanan_operasi, ?)',
            ['"'.$layanan.'"']
        );
    }

    /**
     * Scope: filter RS dalam radius km dari koordinat tertentu.
     * Menggunakan Haversine formula di level SQL.
     */
    public function scopeWithinRadius(Builder $query, float $lat, float $lng, int $radiusKm): Builder
    {
        return $query
            ->selectRaw('
                *,
                (6371 * acos(
                    LEAST(1, cos(radians(?)) * cos(radians(latitude))
                    * cos(radians(longitude) - radians(?))
                    + sin(radians(?)) * sin(radians(latitude)))
                )) AS distance_km
            ', [$lat, $lng, $lat])
            ->having('distance_km', '<=', $radiusKm)
            ->orderBy('distance_km');
    }

    /** Cek apakah RS memiliki layanan tertentu */
    public function hasLayanan(string $layanan): bool
    {
        return in_array($layanan, $this->layanan_list);
    }
}
