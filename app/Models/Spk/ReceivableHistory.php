<?php

namespace App\Models\Spk;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Header riwayat penagihan piutang per nomor SR (Service Request).
 *
 * Setiap kali user meng-assign nomor tagihan ke SPK, sebuah record header ini
 * dibuat. Detail per-piutang (NomorPiutang) disimpan di ReceivableHistoryDetail.
 *
 * Callers : BillingUpdate, SyncReceivableDataHistoriesFromBsi
 * Relations: SpkMain (parent), User (updated_by), ReceivableHistoryDetail (details)
 */
class ReceivableHistory extends Model
{
    use HasUlids, SoftDeletes;

    protected $table = 'tb_spk_receivable_histories';

    protected $fillable = [
        'spk_id',
        'nomor_sr',
        'tipe_tagihan',
        'subtotal',
        'total',
        'jumlah_piutang',
        'jumlah_piutang_field',
        'sisa_piutang_total',
        'source',
        'updated_by',
        'checked_at',
    ];

    protected function casts(): array
    {
        return [
            'subtotal'           => 'integer',
            'total'              => 'integer',
            'jumlah_piutang'     => 'integer',
            'sisa_piutang_total' => 'integer',
            'checked_at'         => 'datetime',
        ];
    }

    /**
     * Cascade soft-delete dan restore ke semua detail yang berelasi.
     *
     * Karena parent menggunakan SoftDeletes, event ON DELETE CASCADE di MySQL
     * tidak akan terpicu — detail perlu dikelola secara eksplisit dari sini.
     */
    protected static function booted(): void
    {
        static::deleting(function (ReceivableHistory $history) {
            DB::transaction(function () use ($history) {
                if ($history->isForceDeleting()) {
                    $history->details()->forceDelete();
                } else {
                    $history->details()->delete();
                }
            });
        });

        static::restoring(function (ReceivableHistory $history) {
            DB::transaction(function () use ($history) {
                $history->details()->restore();
            });
        });
    }

    // -------------------------------------------------------------------------
    // Relations
    // -------------------------------------------------------------------------

    public function spk(): BelongsTo
    {
        return $this->belongsTo(SpkMain::class);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(ReceivableHistoryDetail::class, 'receivable_history_id', 'id');
    }

    // -------------------------------------------------------------------------
    // Business Logic
    // -------------------------------------------------------------------------

    /**
     * Kembalikan detail di-grup per nomor_piutang beserta kalkulasi totalInvoicePaid per group.
     * Dipakai di history.blade.php untuk menghindari @php di Blade.
     *
     * @return Collection<string, array{group: Collection, latestDetail: ReceivableHistoryDetail, totalInvoicePaid: int}>
     */
    public function groupedDetails(): Collection
    {
        return $this->details
            ->groupBy('nomor_piutang')
            ->map(function (Collection $group) {
                $latestDetail = $group->sortByDesc('id')->first();

                $totalInvoicePaid = $group
                    ->where('is_dp', false)
                    ->sum(function ($d) {
                        return is_null($d->sisa_sebelum)
                            ? $d->total_bayar
                            : $d->sisa_sebelum - $d->sisa_piutang;
                    });

                return [
                    'group'            => $group->sortBy('id'),
                    'latestDetail'     => $latestDetail,
                    'totalInvoicePaid' => $totalInvoicePaid,
                ];
            });
    }

    /**
     * Hitung ulang dan simpan total sisa piutang ke kolom sisa_piutang_total.
     *
     * Strategi "create new row" digunakan saat sync API: setiap ada perubahan angka,
     * row baru dibuat (bukan di-update) untuk menjaga audit trail. Oleh karena itu,
     * kalkulasi ini HARUS menggunakan record terbaru per nomor_piutang agar tidak
     * terjadi double-count dari baris historis yang sudah lama.
     *
     * Logika:
     * 1. Ambil semua detail, group by nomor_piutang, ambil yang paling baru per group.
     * 2. Filter hanya baris non-DP (is_dp == false).
     * 3. sisa_piutang_total = jumlah_piutang (acuan header) - sum(total_bayar dari non-DP terbaru).
     */
    public function recalculateSisaPiutangTotal(): void
    {
        $latestPerNomor = $this->details()
            ->get()
            ->groupBy('nomor_piutang')
            ->map(fn ($group) => $group->sortByDesc('id')->first());

        $nonDpSum = $latestPerNomor
            ->filter(fn ($d) => ! $d->is_dp)
            ->sum('total_bayar');

        $this->update(['sisa_piutang_total' => $this->jumlah_piutang - $nonDpSum]);
    }
}
