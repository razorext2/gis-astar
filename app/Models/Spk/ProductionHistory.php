<?php

namespace App\Models\Spk;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionHistory extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'tb_produksi_histories';

    protected $fillable = [
        'id_produksi',
        'judul',
        'keterangan',
        'documentations',
        'status_produksi',
        'status_validasi',
        'added_by',
        'updated_by',
        'validated_by',
        'validated_at',
    ];

    protected $casts = [
        'documentations' => 'array',
    ];

    protected $appends = [
        'status_produksi_description',
        'status_validasi_description',
    ];

    public function produksi()
    {
        return $this->belongsTo(Production::class, 'id_produksi', 'id');
    }

    public function addedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'added_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }

    public function validatedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'validated_by');
    }

    public function getStatusValidasiDescriptionAttribute()
    {
        $status = (int) ($this->attributes['status_validasi'] ?? 0);

        return match ($status) {
            0 => 'Belum Divalidasi',
            1 => 'Approved',
            2 => 'Rejected',
            3 => 'Revision',
            default => 'Status tidak diketahui',
        };
    }

    public function getStatusProduksiDescriptionAttribute()
    {
        $status = (int) ($this->attributes['status_produksi'] ?? 0);

        return match ($status) {
            0 => [
                'label' => 'SPK Dibuat',
                'percentage' => 0,
            ],
            1 => [
                'label' => 'Pengadaan Material',
                'percentage' => 10,
            ],
            2 => [
                'label' => 'Penandaan & Pemotongan',
                'percentage' => 20,
            ],
            3 => [
                'label' => 'Penyetelan',
                'percentage' => 30,
            ],
            4 => [
                'label' => 'Pengelasan',
                'percentage' => 40,
            ],
            5 => [
                'label' => 'Pengeboran & Tapping',
                'percentage' => 50,
            ],
            6 => [
                'label' => 'Perakitan & Pengujian',
                'percentage' => 60,
            ],
            7 => [
                'label' => 'Prosedur NDT',
                'percentage' => 70,
            ],
            8 => [
                'label' => 'Sandblasting',
                'percentage' => 80,
            ],
            9 => [
                'label' => 'Pengecatan',
                'percentage' => 90,
            ],
            10 => [
                'label' => 'Selesai',
                'percentage' => 100,
            ],
            default => [
                'label' => 'Status Produksi Tidak Diketahui',
                'percentage' => null,
            ],
        };
    }
}
