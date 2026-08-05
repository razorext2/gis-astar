<?php

namespace App\Models;

use App\Enums\StatusRujukan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rujukan extends Model
{
    use HasFactory;

    protected $table = 'rujukan';

    protected $primaryKey = 'id_rujukan';

    protected $fillable = [
        'no_rujukan',
        'id_pasien',
        'id_rumah_sakit',
        'id_user',
        'tanggal_rujukan',
        'status',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'status' => StatusRujukan::class,
            'tanggal_rujukan' => 'datetime',
        ];
    }

    /** Pasien yang dirujuk */
    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id_pasien');
    }

    /** RS tujuan rujukan */
    public function rumahSakit(): BelongsTo
    {
        return $this->belongsTo(RumahSakit::class, 'id_rumah_sakit', 'id_rumah_sakit');
    }

    /** Dokter yang membuat rujukan */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /** Detail hasil kalkulasi A* */
    public function detailRujukan(): HasOne
    {
        return $this->hasOne(DetailRujukan::class, 'id_rujukan', 'id_rujukan');
    }

    /** Log perubahan status */
    public function riwayat(): HasMany
    {
        return $this->hasMany(RiwayatRujukan::class, 'id_rujukan', 'id_rujukan')
            ->orderBy('waktu_perubahan');
    }

    /**
     * Generate nomor rujukan otomatis.
     * Format: RJK-YYYYMMDD-XXXXX
     */
    public static function generateNoRujukan(): string
    {
        $date = now()->format('Ymd');
        $sequence = static::whereDate('created_at', today())->count() + 1;

        return sprintf('RJK-%s-%05d', $date, $sequence);
    }
}
