<?php

namespace App\Models\Spk;

use Illuminate\Database\Eloquent\Model;

class SpkDelivery extends Model
{
    protected $table = 'tb_spk_delivery';

    protected $fillable = [
        'id_spk',
        'kode_kirim',
        'status_kirim',
        'nomor_sr',
        'via',
        'partay',
        'no_container',
        'nama_kapal',
        'no_plat',
        'nama_supir',
        'id_supir',
        'no_telp_supir',
        'berat',
        'etd',
        'eta',
        'note',
        'products',
        'is_delay',
        'history',
    ];

    protected $casts = [
        'products' => 'array',
        'is_delay' => 'array',
        'history' => 'array',
    ];

    public function spk()
    {
        return $this->belongsTo(SpkMain::class, 'id_spk', 'id');
    }

    public function supir()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_supir', 'kode_pegawai');
    }

    public function getProductDetailsAttribute()
    {
        $production = $this->spk?->production;

        if (! $production || ! $production->packing_list) {
            return collect();
        }

        $indexed = collect($production->packing_list)
            ->keyBy('id_barang');

        return collect($this->products ?? [])
            ->map(fn ($id) => $indexed[$id] ?? null)
            ->filter()
            ->values();
    }

    public function getStatusKirimDescriptionAttribute()
    {
        $status = (int) ($this->attributes['status_kirim'] ?? null);

        return match ($status) {
            0 => 'Dalam Pengiriman',
            1 => 'Pengiriman Selesai',
            2 => 'Pengiriman Mengalami Delay',
            3 => 'Pengiriman Dibatalkan',
            4 => 'Pengiriman Direschedule',
            default => 'Status Pengiriman tidak diketahui',
        };
    }
}
