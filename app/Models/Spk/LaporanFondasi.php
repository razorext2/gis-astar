<?php

namespace App\Models\Spk;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaporanFondasi extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'tb_laporan_fondasi';

    protected $fillable = [
        'id_spk',
        'judul',
        'dokumentasi',
        'keterangan',
        'status_pengerjaan',
        'added_by',
    ];

    protected $casts = [
        'dokumentasi' => 'array',
        'status_pengerjaan' => 'integer',
    ];

    protected $appends = [
        'status_pengerjaan_description',
    ];

    public function spk()
    {
        return $this->belongsTo(\App\Models\Spk\SpkMain::class, 'id_spk', 'id');
    }

    public function addedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'added_by', 'id');
    }

    public function getStatusPengerjaanDescriptionAttribute()
    {
        $status = (int) ($this->attributes['status_pengerjaan'] ?? 0);

        return match ($status) {
            10 => 'Persiapan bahan',
            33 => 'Tahap 1',
            50 => 'Tahap 2',
            88 => 'Finishing',
            100 => 'Selesai',
            default => 'Status fondasi tidak diketahui.'
        };
    }
}
