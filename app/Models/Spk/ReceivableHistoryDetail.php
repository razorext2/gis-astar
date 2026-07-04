<?php

namespace App\Models\Spk;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Detail baris piutang per NomorPiutang dari laporan BSI.
 *
 * Setiap header ReceivableHistory memiliki satu atau lebih baris detail.
 * Baris DP (uang muka) dapat ditandai oleh user via flag is_dp.
 *
 * Callers : BillingUpdate, SyncReceivableDataHistoriesFromBsi
 * Relations: ReceivableHistory (parent header)
 */
class ReceivableHistoryDetail extends Model
{
    use HasUlids, SoftDeletes;

    protected $table = 'tb_spk_receivable_history_details';

    protected $fillable = [
        'receivable_history_id',
        'nomor_piutang',
        'jumlah_piutang',
        'total_bayar',
        'sisa_piutang',
        'sisa_sebelum',
        'is_dp',
        'source',
        'checked_at',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_piutang' => 'integer',
            'total_bayar'    => 'integer',
            'sisa_piutang'   => 'integer',
            'sisa_sebelum'   => 'integer',
            'is_dp'          => 'boolean',
            'checked_at'     => 'datetime',
        ];
    }

    // -------------------------------------------------------------------------
    // Relations
    // -------------------------------------------------------------------------

    public function receivableHistory(): BelongsTo
    {
        return $this->belongsTo(ReceivableHistory::class, 'receivable_history_id', 'id');
    }
}
