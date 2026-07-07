<?php

/** Goal: Domain service untuk proses assign nomor tagihan BSI ke SPK, Caller: Preview Livewire component, Deps: SpkMain, ReceivableHistory, Auth, DB */

namespace App\Services\Spk\Billing;

use App\Models\Spk\ReceivableHistory;
use App\Models\Spk\SpkMain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssignService
{
    /**
     * Assign nomor tagihan BSI ke SPK secara atomic dalam satu transaksi.
     *
     * @param  array<int, array<string, mixed>>  $sisaItems
     */
    public function assign(
        SpkMain $spk,
        string $formTipeTagihan,
        string $nomorTagihanBaru,
        float $subtotal,
        float $total,
        float $jumlahPiutang,
        string $jumlahPiutangField,
        int $totalSisaDihitung,
        array $sisaItems,
    ): void {
        DB::transaction(function () use (
            $spk,
            $formTipeTagihan,
            $nomorTagihanBaru,
            $subtotal,
            $total,
            $jumlahPiutang,
            $jumlahPiutangField,
            $totalSisaDihitung,
            $sisaItems,
        ) {
            $this->updateSpkForAssign($spk, $formTipeTagihan, $nomorTagihanBaru);
            $history = $this->createReceivableHistory(
                $spk, $nomorTagihanBaru, $formTipeTagihan,
                $subtotal, $total, $jumlahPiutang, $jumlahPiutangField, $totalSisaDihitung
            );
            $this->createReceivableDetails($history, $sisaItems);
            $this->logAssignAudit($spk, $nomorTagihanBaru);
        });
    }

    private function updateSpkForAssign(SpkMain $spk, string $tipeTagihan, string $nomorTagihan): void
    {
        $updated = $spk->update([
            'tipe_tagihan' => $tipeTagihan,
            'nomor_tagihan' => $nomorTagihan,
            'status_nomor_tagihan' => 1,
            'status' => 4,
            'updated_by' => Auth::id(),
            'no_tagihan_updated_by' => Auth::id(),
        ]);

        if (! $updated) {
            throw new \Exception('Gagal update nomor tagihan di SPK.');
        }
    }

    private function createReceivableHistory(
        SpkMain $spk,
        string $nomorSr,
        string $tipeTagihan,
        float $subtotal,
        float $total,
        float $jumlahPiutang,
        string $jumlahPiutangField,
        int $sisaPiutangTotal,
    ): ReceivableHistory {
        $history = ReceivableHistory::create([
            'spk_id' => $spk->id,
            'nomor_sr' => $nomorSr,
            'tipe_tagihan' => $tipeTagihan,
            'subtotal' => (int) $subtotal,
            'total' => (int) $total,
            'jumlah_piutang' => (int) $jumlahPiutang,
            'jumlah_piutang_field' => $jumlahPiutangField,
            'sisa_piutang_total' => $sisaPiutangTotal,
            'source' => 'manual',
            'updated_by' => Auth::id(),
            'checked_at' => now(),
        ]);

        if (! $history) {
            throw new \Exception('Gagal membuat header riwayat piutang.');
        }

        return $history;
    }

    /**
     * @param  array<int, array<string, mixed>>  $sisaItems
     */
    private function createReceivableDetails(ReceivableHistory $history, array $sisaItems): void
    {
        foreach ($sisaItems as $item) {
            $detail = $history->details()->create([
                'nomor_piutang' => $item['NomorPiutang'] ?? null,
                'jumlah_piutang' => (int) ($item['JumlahPiutang'] ?? 0),
                'total_bayar' => (int) ($item['TotalBayar'] ?? 0),
                'sisa_piutang' => (int) ($item['SisaPiutang'] ?? 0),
                'is_dp' => (bool) ($item['is_dp'] ?? false),
                'source' => 'manual',
                'checked_at' => now(),
            ]);

            if (! $detail) {
                throw new \Exception('Gagal membuat detail riwayat piutang.');
            }
        }
    }

    private function logAssignAudit(SpkMain $spk, string $nomorTagihan): void
    {
        $spk->addHistory(
            'Nomor SR penagihan di-assign.',
            Auth::user()->name.' telah meng-assign nomor SR penagihan ('.$nomorTagihan.').',
            Auth::id()
        );
    }
}
