<?php

namespace App\Livewire\Handler\Point\Technician;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\PointTransactions;
use App\Models\TechnicianPoints;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Redeem extends Component
{
    use HandlesErrors;

    #[Validate('required|date')]
    public $start_period;

    #[Validate('required|date')]
    public $end_period;

    #[Validate('required|in:1,2,3,4')]
    public $quarter;

    public $result;

    public $transactionID;

    public $no_vt = [];

    public $showModal = false;

    #[Url]
    public $step = 1;

    public function mount()
    {
        $this->start_period = Carbon::now()->subMonths(3)->format('Y-m-26');
        $this->end_period = Carbon::now()->format('Y-m-25');
        $this->result = collect();
    }

    public function process()
    {
        $this->validate();

        $transaction = PointTransactions::where('from_date', '>=', $this->start_period)
            ->where('to_date', '<=', $this->end_period)
            ->where('quartal', $this->quarter);

        if ($transaction->exists()) {
            $query = $transaction->where('quartal', $this->quarter)
                ->where('year', Carbon::parse($this->end_period)->year)
                ->with('pegawai', 'redeemedby')->get();

            $this->result = $query;
            $this->step = 3;

            return;
        }

        $this->result = TechnicianPoints::whereBetween('created_at', [$this->start_period, $this->end_period])
            ->where('is_redeemable', 1)
            ->where('is_redeemed', 0)
            ->where('redeemed_status', 0)
            ->orderBy('kode_pegawai')
            ->get()
            ->groupBy('kode_pegawai')
            ->toBase();

        $this->step = 2;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function validateData()
    {
        $transactionID = \Illuminate\Support\Str::uuid();

        $this->runSafely(function () use ($transactionID) {
            DB::transaction(function () use ($transactionID) {
                $points = TechnicianPoints::whereBetween('created_at', [$this->start_period, $this->end_period])
                    ->where('is_redeemable', 1);

                foreach ($this->result as $kodePegawai => $group) {
                    PointTransactions::create([
                        'transaction_id' => $transactionID,
                        'quartal' => $this->quarter,
                        'year' => Carbon::parse($this->end_period)->year,
                        'point_type' => 'technician',
                        'kode_pegawai' => $kodePegawai,
                        'redeemed_by' => auth()->id(),
                        'from_date' => $this->start_period,
                        'to_date' => $this->end_period,
                        'valid_points' => $group->sum('point'),
                        'invalid_points' => 0,
                        'total_points' => $group->sum('point'),
                        'status' => 1, // confirmation
                    ]);
                }

                $points->update([
                    'redeemed_status' => 1,
                    'redeemed_date' => now(),
                ]);
            });

            $this->step = 3;
            $this->summary($transactionID);
        }, 'Gagal memvalidasi/membuat data transaksi point pengajuan.', [
            'action' => 'validate points tech',
            'user_id' => auth()->id(),
        ]);
    }

    public function summary($transactionID)
    {
        $query = PointTransactions::with('pegawai', 'redeemedby')
            ->where('transaction_id', $transactionID)->get();

        if (! $query) {
            return $this->dispatch('swal', title: 'Error', text: 'Data tidak ditemukan', icon: 'error');
        }

        $this->result = $query;
    }

    public function processRedeem($transactionID)
    {
        $this->transactionID = $transactionID;

        $this->runSafely(function () {
            DB::transaction(function () {
                TechnicianPoints::whereBetween('created_at', [$this->start_period, $this->end_period])
                    ->where('is_redeemable', 1)
                    ->update([
                        'redeemed_status' => 2, // diajukan ke hrd
                    ]);

                PointTransactions::where('transaction_id', $this->transactionID)
                    ->update([
                        'status' => 2,
                    ]);
            });

            // Refresh status display by reloading transaction data
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
