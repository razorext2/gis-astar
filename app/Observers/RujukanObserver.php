<?php

namespace App\Observers;

use App\Models\RiwayatRujukan;
use App\Models\Rujukan;
use Illuminate\Support\Facades\Auth;

/**
 * Observer untuk model Rujukan.
 * Otomatis mencatat perubahan status ke tabel riwayat_rujukan.
 */
class RujukanObserver
{
    /**
     * Dipanggil sebelum Rujukan diupdate.
     * Jika field 'status' berubah → INSERT riwayat_rujukan.
     */
    public function updating(Rujukan $rujukan): void
    {
        if ($rujukan->isDirty('status')) {
            RiwayatRujukan::create([
                'id_rujukan' => $rujukan->id_rujukan,
                'status_lama' => $rujukan->getOriginal('status')?->value
                    ?? $rujukan->getOriginal('status'),
                'status_baru' => $rujukan->status->value,
                'keterangan' => 'Status diubah melalui sistem',
                'diubah_oleh' => Auth::id(),
                'waktu_perubahan' => now(),
            ]);
        }
    }
}
