<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasUlids, SoftDeletes;

    protected $table = 'tb_invoice';

    protected $fillable = [
        'nomor_btt',
        'tgl_btt',
        'tgl_invoice',
        'no_piutang',
        'no_penjualan',
        'no_faktur_pajak',
        'tipe_tagihan',
        'nama_customer',
        'tipe_invoice',
        'status_pengiriman',
        'status_awal',
        'status_terbaru',
        'added_by',
        'latest_update_by',
    ];

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    public function latestUpdateBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'latest_update_by', 'id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(InvoiceDetail::class, 'no_faktur_pajak', 'no_faktur_pajak');
    }
}
