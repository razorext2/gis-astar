<?php

namespace App\Models;

use App\Enums\JenisKelamin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    protected $primaryKey = 'id_pasien';

    protected $fillable = [
        'id_user',
        'nik',
        'no_rm',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'no_telepon',
        'latitude',
        'longitude',
    ];

    protected function casts(): array
    {
        return [
            'jenis_kelamin' => JenisKelamin::class,
            'tanggal_lahir' => 'date',
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    /** Dokter / user yang menginput data pasien */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /** Daftar rujukan untuk pasien ini */
    public function rujukan(): HasMany
    {
        return $this->hasMany(Rujukan::class, 'id_pasien', 'id_pasien');
    }

    /** Cek apakah koordinat pasien sudah terisi */
    public function hasCoordinates(): bool
    {
        return $this->latitude !== null && $this->longitude !== null;
    }

    /** Usia pasien dalam tahun */
    public function getUmurAttribute(): ?int
    {
        return $this->tanggal_lahir?->age;
    }
}
