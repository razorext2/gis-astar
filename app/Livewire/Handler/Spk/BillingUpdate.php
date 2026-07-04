<?php

namespace App\Livewire\Handler\Spk;

use App\Livewire\Concerns\HandlesErrors;
use App\Livewire\Forms\Billing;
use App\Models\Spk\ReceivableHistory;
use App\Models\Spk\ReceivableHistoryDetail;
use App\Models\Spk\SpkMain;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * Handler assign/unassign nomor tagihan BSI ke SPK dan menampilkan riwayat piutang.
 *
 * Caller  : billing-update.blade.php
 * Deps    : Billing (Form), SpkMain, ReceivableHistory, ReceivableHistoryDetail, DB
 */
class BillingUpdate extends Component
{
    use HandlesErrors;

    public Billing $form;

    public SpkMain $spk_data;

    /** Tampilkan modal konfirmasi unassign nomor tagihan */
    public bool $showUnassignConfirm = false;

    /**
     * Total sisa piutang yang dihitung dari sisaItems sebelum data di-assign.
     * Exclude baris yang is_dp = true, kecuali jika ada DP maka dihitung sebagai selisih.
     */
    public float $totalSisaDihitung = 0;

    /** Selisih antara jumlah_piutang (acuan user) dengan totalSisaDihitung */
    public float $totalSelisih = 0;

    /** Total DP yang dibayar */
    public float $totalDpPaid = 0;

    // -------------------------------------------------------------------------
    // Lifecycle
    // -------------------------------------------------------------------------

    public function mount(string $id): void
    {
        $this->spk_data = SpkMain::with('invoice', 'receivableHistories')
            ->findOrFail($id);

        $this->form->nomor_tagihan = $this->spk_data->nomor_tagihan;
        $this->form->status_nomor_tagihan = $this->spk_data->status_nomor_tagihan;
        $this->form->tipe_tagihan = $this->spk_data->tipe_tagihan;
    }

    // -------------------------------------------------------------------------
    // Search & Preview (sebelum assign)
    // -------------------------------------------------------------------------

    /**
     * Fetch data SR/FP dan laporan sisa piutang dari API BSI.
     * Hasil ditampilkan sebagai preview sebelum user melakukan assign.
     */
    public function search(): void
    {
        $this->form->validate();

        $tipeTagihan = config('spk-config.spk_tipe_tagihan')[$this->form->tipe_tagihan];

        try {
            $mainData = $this->form->fetchApi($tipeTagihan['api'], $this->form->nomor_tagihan);
        } catch (\Throwable $e) {
            $this->form->clearResults();
            $this->dispatch('swal', icon: 'error', title: 'Gagal', text: $e->getMessage());

            return;
        }

        $this->form->nama_customer = $mainData['NamaCustomer'] ?? null;
        $this->form->customer_contact = $mainData['CustomerContact'] ?? null;
        $this->form->nomor_tagihan_baru = $mainData['NomorPermintaanJual'] ?? null;
        $this->form->subtotal = (float) ($mainData['SubTotal'] ?? 0);
        $this->form->total = (float) ($mainData['Total'] ?? 0);

        // Default field acuan tergantung tipe tagihan; user bisa mengubah via radio button di UI
        $this->form->jumlah_piutang_field = $this->form->resolveDefaultJumlahPiutangField();
        $this->recalculateJumlahPiutang();

        $this->form->sisaItems = [];
        $this->totalSisaDihitung = 0;
        $this->totalSelisih = 0;

        try {
            $sisaItems = $this->form->fetchSisa($tipeTagihan['api_sisa'], $this->form->nomor_tagihan);

            // Inject is_dp = false ke setiap item agar bisa ditandai user sebelum assign
            $this->form->sisaItems = array_map(
                fn (array $item) => array_merge($item, ['is_dp' => false]),
                $sisaItems
            );

            $this->recalculateSisaTotals();

            if (empty($this->form->nama_customer)) {
                $this->form->nama_customer = $sisaItems[0]['NamaCustomer'] ?? null;
            }

            $this->dispatch('scroll-to-rekap');
        } catch (\Throwable) {
            $this->form->clearResults();
            $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'Gagal mengambil data penagihan di laporan piutang BSI.');
        }
    }

    /** Toggle is_dp pada baris sisaItem (sebelum assign) dan hitung ulang totals */
    public function toggleSisaItemDp(int $index): void
    {
        if (! isset($this->form->sisaItems[$index])) {
            return;
        }

        $this->form->sisaItems[$index]['is_dp'] = ! ($this->form->sisaItems[$index]['is_dp'] ?? false);

        $this->recalculateSisaTotals();
    }

    /** Dipanggil saat user mengubah pilihan radio SubTotal/Total untuk menggeser acuan piutang */
    public function updated(string $property): void
    {
        if ($property === 'form.jumlah_piutang_field') {
            $this->recalculateJumlahPiutang();
            $this->recalculateSisaTotals();
        }
    }

    /** Reset hasil pencarian agar user bisa mencari ulang */
    public function clearSearch(): void
    {
        $this->form->clearResults();
        $this->totalSisaDihitung = 0;
        $this->totalSelisih = 0;
    }

    /**
     * Assign nomor tagihan BSI ke SPK beserta riwayat piutang-nya.
     *
     * Flow:
     * 1. Validasi kesamaan nama customer antara SPK dan hasil API.
     * 2. Cek policy berdasarkan tipe tagihan.
     * 3. Jalankan transaksi: update SPK → buat header history → buat detail baris → catat audit log.
     */
    public function assign(): void
    {
        $customerFromDb = (string) $this->form->sanitizeAlphaNumeric($this->spk_data->customer['nama_perusahaan']);
        $customerFromApi = (string) $this->form->sanitizeAlphaNumeric($this->form->nama_customer);

        $policy = match ($this->form->tipe_tagihan) {
            'idcnon' => 'updateNoTagihanIdcNonPpn',
            'idcppn' => 'updateNoTagihanIdcPpn',
            'idyppn' => 'updateNoTagihanIdyPpn',
        };

        $this->authorize($policy, SpkMain::class);

        if ($customerFromDb !== $customerFromApi) {
            $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'Data customer tidak sama.');

            return;
        }

        $this->runSafely(function () {
            DB::transaction(function () {
                $this->updateSpkForAssign();
                $history = $this->createReceivableHistory();
                $this->createReceivableDetails($history);
                $this->logAssignAudit();
            });

            $this->dispatch(
                event: 'swal',
                icon: 'success',
                title: 'Berhasil',
                text: 'Nomor tagihan berhasil diassign.',
                redirect: [
                    'url' => route('billing.index'),
                    'delay' => 2500,
                ]
            );
        }, 'Gagal assign nomor tagihan', [
            'form' => ['id_spk' => $this->spk_data->id, 'nomor_tagihan' => $this->form->nomor_tagihan_baru],
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * Unassign nomor tagihan dari SPK dan soft-delete semua riwayat piutang terkait.
     * Detail ikut terhapus (soft-delete) melalui event booted() di model ReceivableHistory.
     */
    public function unassign(): void
    {
        $this->authorize('unassignNoTagihan', SpkMain::class);

        $this->showUnassignConfirm = false;
        $nomorTagihanLama = $this->spk_data->nomor_tagihan;

        $this->runSafely(function () use ($nomorTagihanLama) {
            DB::transaction(function () use ($nomorTagihanLama) {
                $updated = $this->spk_data->update([
                    'nomor_tagihan' => null,
                    'status_nomor_tagihan' => 0,
                    'status' => 3,
                    'updated_by' => Auth::id(),
                    'no_tagihan_updated_by' => Auth::id(),
                ]);

                if (! $updated) {
                    throw new \Exception('Gagal mereset nomor tagihan.');
                }

                // Soft-delete semua history piutang — detail ikut terhapus via cascade di booted()
                $this->spk_data->receivableHistories()->delete();

                $this->spk_data->addHistory(
                    'Nomor SR penagihan di-unassign.',
                    Auth::user()->name.' telah meng-unassign nomor SR penagihan ('.$nomorTagihanLama.').',
                    Auth::id()
                );
            });

            $this->spk_data->refresh();
            $this->form->nomor_tagihan = null;
            $this->form->status_nomor_tagihan = false;
            $this->clearSearch();

            $this->dispatch(event: 'swal', icon: 'success', title: 'Berhasil', text: 'Nomor tagihan berhasil di-unassign.');
        }, 'Gagal unassign nomor tagihan', [
            'id_spk' => $this->spk_data->id,
            'nomor_tagihan' => $nomorTagihanLama,
            'user_id' => Auth::id(),
        ]);
    }

    #[Computed]
    public function histories(): Collection
    {
        if (is_null($this->spk_data->nomor_tagihan)) {
            return collect();
        }

        return $this->spk_data->receivableHistories()
            ->with(['details', 'updatedBy'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render(): View
    {
        return view('livewire.handler.spk.billing-update');
    }

    /** Update kolom tagihan di SPK saat assign dilakukan */
    private function updateSpkForAssign(): void
    {
        $updated = $this->spk_data->update([
            'tipe_tagihan' => $this->form->tipe_tagihan,
            'nomor_tagihan' => $this->form->nomor_tagihan_baru,
            'status_nomor_tagihan' => 1,
            'status' => 4,
            'updated_by' => Auth::id(),
            'no_tagihan_updated_by' => Auth::id(),
        ]);

        if (! $updated) {
            throw new \Exception('Gagal update nomor tagihan di SPK.');
        }
    }

    /** Buat header ReceivableHistory berdasarkan data form dan sisa piutang yang sudah dihitung */
    private function createReceivableHistory(): ReceivableHistory
    {
        $history = ReceivableHistory::create([
            'spk_id' => $this->spk_data->id,
            'nomor_sr' => $this->form->nomor_tagihan_baru,
            'tipe_tagihan' => $this->form->tipe_tagihan,
            'subtotal' => (int) $this->form->subtotal,
            'total' => (int) $this->form->total,
            'jumlah_piutang' => (int) $this->form->jumlah_piutang,
            'jumlah_piutang_field' => $this->form->jumlah_piutang_field,
            'sisa_piutang_total' => (int) $this->totalSisaDihitung,
            'source' => 'manual',
            'updated_by' => Auth::id(),
            'checked_at' => now(),
        ]);

        if (! $history) {
            throw new \Exception('Gagal membuat header riwayat piutang.');
        }

        return $history;
    }

    /** Buat baris detail ReceivableHistoryDetail dari setiap sisaItem yang sudah dipreview user */
    private function createReceivableDetails(ReceivableHistory $history): void
    {
        foreach ($this->form->sisaItems as $item) {
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

    /** Catat audit log bahwa nomor SR penagihan telah di-assign */
    private function logAssignAudit(): void
    {
        $this->spk_data->addHistory(
            'Nomor SR penagihan di-assign.',
            Auth::user()->name.' telah meng-assign nomor SR penagihan ('.$this->form->nomor_tagihan_baru.').',
            Auth::id()
        );
    }

    /** Sinkronkan jumlah_piutang dengan field acuan yang dipilih user (subtotal atau total) */
    private function recalculateJumlahPiutang(): void
    {
        $this->form->jumlah_piutang = $this->form->jumlah_piutang_field === 'total'
            ? $this->form->total
            : $this->form->subtotal;
    }

    /**
     * Hitung ulang totalSisaDihitung, total_bayar, dan totalSelisih berdasarkan sisaItems.
     *
     * Logika:
     * - Baris yang ditandai sebagai DP (is_dp == true) TIDAK mengurangi nilai total piutang (acuan).
     * - Hanya baris non-DP (is_dp == false) yang mengurangi nilai total piutang (acuan).
     */
    private function recalculateSisaTotals(): void
    {
        $items = collect($this->form->sisaItems);
        $nonDpItems = $items->where('is_dp', false);
        $dpItems = $items->where('is_dp', true);

        // Total bayar yang diakui mengurangi piutang adalah dari baris non-DP
        $this->form->total_bayar = $nonDpItems->sum(fn (array $item) => (float) ($item['TotalBayar'] ?? 0));

        // Total DP yang dibayar
        $this->totalDpPaid = $dpItems->sum(fn (array $item) => (float) ($item['TotalBayar'] ?? 0));

        // Sisa piutang dihitung = acuan piutang - total bayar non-DP
        $this->totalSisaDihitung = $this->form->jumlah_piutang - $this->form->total_bayar;

        $this->form->sisa = $this->totalSisaDihitung;

        // Selisih (Acuan vs Sisa BSI) = jumlah_piutang - (total_bayar + sisa_piutang_bsi)
        $nonDpSisa = $nonDpItems->sum(fn (array $item) => (float) ($item['SisaPiutang'] ?? 0));
        $this->totalSelisih = $this->form->jumlah_piutang - ($this->form->total_bayar + $nonDpSisa);
    }
}
