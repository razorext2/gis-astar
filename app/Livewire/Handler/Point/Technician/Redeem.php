<?php

/** Goal: Quartal-based redeem with dual mode (all/selected), Caller: redeem.blade.php, Deps: QuartalService, PointTransactions, TechnicianPoints */

namespace App\Livewire\Handler\Point\Technician;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\PointTransactions;
use App\Models\TechnicianPoints;
use App\Services\TechnicianPoint\QuartalService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Redeem extends Component
{
    use HandlesErrors;

    #[Validate('required|in:1,2,3,4')]
    public $quarter;

    #[Validate('required|integer|min:2020')]
    public $year;

    /** @var string 'all' or 'selected' */
    public string $redeemMode = 'all';

    /** @var array<string> kode_pegawai yang dipilih (mode selected) */
    public array $selectedPegawai = [];

    public $result;

    public $transactionID;

    public bool $showModal = false;

    /** @var bool quartal sudah pernah di-redeem (fully) */
    public bool $isQuartalRedeemed = false;

    /** @var array<string> kode pegawai yang sudah di-redeem di quartal ini */
    public array $alreadyRedeemedPegawai = [];

    #[Url]
    public $step = 1;

    protected QuartalService $quartalService;

    public function boot(QuartalService $quartalService): void
    {
        $this->quartalService = $quartalService;
    }

    public function mount(): void
    {
        $current = $this->quartalService->getCurrentQuartal();
        $this->quarter = $current['quarter'];
        $this->year = $current['year'];
        $this->result = collect();

        $this->checkQuartalStatus();
    }

    /**
     * Auto-computed date range dari quartal + year yang dipilih.
     *
     * @return array{from: \Carbon\Carbon, to: \Carbon\Carbon}
     */
    #[Computed]
    public function dateRange(): array
    {
        return $this->quartalService->getQuartalRange((int) $this->quarter, (int) $this->year);
    }

    /**
     * @return array<int>
     */
    #[Computed]
    public function availableYears(): array
    {
        return $this->quartalService->getAvailableYears();
    }

    public function updatedQuarter(): void
    {
        $this->checkQuartalStatus();
    }

    public function updatedYear(): void
    {
        $this->checkQuartalStatus();
    }

    #[On('pegawaiSelectionUpdated')]
    public function handlePegawaiSelection(array $selectedPegawai): void
    {
        $this->selectedPegawai = $selectedPegawai;
    }

    /**
     * Cek apakah quartal sudah di-redeem dan siapa saja yang sudah.
     */
    protected function checkQuartalStatus(): void
    {
        if (! $this->quarter || ! $this->year) {
            return;
        }

        $this->alreadyRedeemedPegawai = $this->quartalService->getRedeemedPegawaiInQuartal(
            (int) $this->quarter,
            (int) $this->year
        );

        $this->isQuartalRedeemed = $this->quartalService->isAlreadyRedeemed(
            (int) $this->quarter,
            (int) $this->year
        );
    }

    /**
     * Step 1 → Step 2: Fetch data poin yang bisa di-redeem.
     */
    public function process(): void
    {
        $this->validate();

        $range = $this->dateRange;

        // Cek apakah sudah ada transaksi existing (bukan rejected) untuk quartal ini
        $existingTransaction = PointTransactions::where('quartal', $this->quarter)
            ->where('year', $this->year)
            ->where('from_date', $range['from']->toDateString())
            ->where('to_date', $range['to']->toDateString())
            ->whereNotIn('status', [4])
            ->with('pegawai', 'redeemedby');

        if ($this->redeemMode === 'all' && $existingTransaction->exists()) {
            // Sudah pernah di-redeem secara penuh, tampilkan summary
            $this->result = $existingTransaction->get();
            $this->step = 3;

            return;
        }

        // Fetch poin yang belum di-redeem
        $this->result = $this->quartalService->getRedeemablePoints($range['from'], $range['to']);

        // Filter out pegawai yang sudah di-redeem di quartal ini
        if (! empty($this->alreadyRedeemedPegawai)) {
            $this->result = $this->result->forget($this->alreadyRedeemedPegawai);
        }

        if ($this->result->isEmpty()) {
            $this->dispatch('swal', icon: 'info', text: 'Tidak ada poin yang bisa di-redeem untuk quartal ini.', title: 'Info');

            return;
        }

        // Reset selection
        $this->selectedPegawai = [];
        $this->step = 2;
    }

    public function openModal(): void
    {
        // Validasi: mode selected harus ada yang dipilih
        if ($this->redeemMode === 'selected' && empty($this->selectedPegawai)) {
            $this->dispatch('swal', icon: 'error', text: 'Pilih minimal satu teknisi untuk di-redeem.', title: 'Gagal');

            return;
        }

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    /**
     * Proses validasi dan buat transaksi redeem.
     */
    public function validateData(): void
    {
        $transactionID = str_replace('-', '', Str::uuid()->toString());
        $range = $this->dateRange;

        $this->runSafely(function () use ($transactionID, $range) {
            DB::transaction(function () use ($transactionID, $range) {
                $dataToRedeem = $this->result;

                // Filter berdasarkan mode
                if ($this->redeemMode === 'selected' && ! empty($this->selectedPegawai)) {
                    $dataToRedeem = $dataToRedeem->only($this->selectedPegawai);
                }

                foreach ($dataToRedeem as $kodePegawai => $group) {
                    // Double-check: skip jika pegawai ini sudah pernah di-redeem
                    if ($this->quartalService->isAlreadyRedeemed((int) $this->quarter, (int) $this->year, $kodePegawai)) {
                        continue;
                    }

                    PointTransactions::create([
                        'transaction_id' => $transactionID,
                        'quartal' => $this->quarter,
                        'year' => $this->year,
                        'point_type' => 'technician',
                        'kode_pegawai' => $kodePegawai,
                        'redeemed_by' => auth()->id(),
                        'from_date' => $range['from']->toDateString(),
                        'to_date' => $range['to']->toDateString(),
                        'valid_points' => $group->sum('point'),
                        'invalid_points' => 0,
                        'total_points' => $group->sum('point'),
                        'status' => 1, // confirmation
                    ]);

                    // Update individual point records
                    TechnicianPoints::whereIn('id', $group->pluck('id'))
                        ->update([
                            'redeemed_status' => 1,
                            'redeemed_date' => now(),
                            'transaction_id' => $transactionID,
                        ]);
                }
            });

            $this->step = 3;
            $this->showModal = false;
            $this->summary($transactionID);
        }, 'Gagal memvalidasi/membuat data transaksi point pengajuan.', [
            'action' => 'validate points tech',
            'user_id' => auth()->id(),
        ]);
    }

    public function summary(string $transactionID): void
    {
        $query = PointTransactions::with('pegawai', 'redeemedby')
            ->where('transaction_id', $transactionID)->get();

        if ($query->isEmpty()) {
            $this->dispatch('swal', title: 'Error', text: 'Data tidak ditemukan', icon: 'error');

            return;
        }

        $this->result = $query;
    }

    /**
     * Proses redeem: update status ke HRD.
     */
    public function processRedeem(string $transactionID): void
    {
        $this->transactionID = $transactionID;

        $this->runSafely(function () {
            DB::transaction(function () {
                $transactions = PointTransactions::where('transaction_id', $this->transactionID)->get();

                foreach ($transactions as $tx) {
                    TechnicianPoints::where('transaction_id', $this->transactionID)
                        ->where('kode_pegawai', $tx->kode_pegawai)
                        ->update(['redeemed_status' => 2]);
                }

                PointTransactions::where('transaction_id', $this->transactionID)
                    ->update(['status' => 2]);
            });

            $this->summary($this->transactionID);
            $this->dispatch('swal', title: 'Berhasil', text: 'Status pengajuan telah berubah menjadi menunggu persetujuan HRD', icon: 'success');
        }, 'Gagal mengajukan pengajuan poin karena error sistem.', [
            'action' => 'submit redeem points',
            'transaction_id' => $this->transactionID,
            'user_id' => auth()->id(),
        ]);
    }

    public function render()
    {
        return view('livewire.handler.point.technician.redeem', [
            'results' => $this->result,
        ]);
    }
}
