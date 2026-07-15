<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';

    protected $table = 'tb_attendance';

    protected $fillable = [
        'kode_pegawai',
        'upl',
        'upl68',
        'uplm68',
        'upljam',
        'jenis',
        'waktuori',
        'timezone',
        'status',
        'jam_masuk',
        'longitude',
        'latitude',
        'position_status',
        'photoURL',
        'verified',
        'distance',
        'verified_by',
        'keterangan',
    ];

    protected $casts = [
        'jam_masuk' => 'datetime',
    ];

    /**
     * Get the display-ready photo src URL, falling back to a no-image asset.
     */
    public function getPhotoSrcAttribute(): string
    {
        $storagePath = "labels/{$this->kode_pegawai}/capturedImg/{$this->photoURL}.png";

        if (Storage::disk('public')->exists($storagePath)) {
            return asset(sha1('libs') . '/' . $this->photoURL . '.png');
        }

        return asset('assets/img/noImage.webp');
    }

    /**
     * Get the parsed Carbon instance of waktuori.
     */
    public function getParsedTimeAttribute(): Carbon
    {
        return Carbon::parse($this->waktuori);
    }

    /**
     * Get the face similarity percentage from distance.
     */
    public function getSimilarityPercentAttribute(): ?float
    {
        if ($this->distance === null) {
            return null;
        }

        return (1 - round($this->distance, 2)) * 100;
    }

    /**
     * Get the formatted late duration from jam_masuk relative to 08:00.
     * Returns null if the attendance was on time or early.
     */
    public function getLateDurationAttribute(): ?string
    {
        $masuk = Carbon::parse($this->jam_masuk);
        $target = $masuk->copy()->setTime(8, 0, 0);
        $diffInSeconds = $target->diffInSeconds($masuk, false);

        if ($diffInSeconds <= 0) {
            return null;
        }

        return gmdate('H:i:s', $diffInSeconds);
    }

    public function pegawaiRelasi()
    {
        return $this->belongsTo(Pegawai::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by', 'id');
    }

    public function scopeNotVerified($query)
    {
        return $query->where('verified', 0)
            ->where('status', 0);
    }
}
