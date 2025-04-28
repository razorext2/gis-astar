<?php

namespace App\Livewire\Handler\Point\Technician;

use App\Models\PointTransactions;
use App\Models\TechnicianPoints;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Redeem extends Component
{
    public $start_period;
    public $end_period;
    public $result;
    public $transactionID;
    public $no_vt = [];
    public $showModal = false;

    // public $apiResponse;

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
        $transaction = PointTransactions::where('from_date', '>=', $this->start_period)
            ->where('to_date', '<=', $this->end_period)
            ->exists();

        if ($transaction) {
            $query = PointTransactions::with('pegawai', 'redeemedby')
                ->where('from_date', $this->start_period)
                ->where('to_date', $this->end_period)
                ->get();

            if (!$query) {
                dd('gagal');
            }

            $this->result = $query;
            $this->step = 3;
            return;
        }

        $this->result = TechnicianPoints::whereBetween('created_at', [$this->start_period, $this->end_period])
            ->where('is_redeemable', 1)
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

        $points = TechnicianPoints::whereBetween('created_at', [$this->start_period, $this->end_period])
            ->where('is_redeemable', 1);

        try {
            DB::beginTransaction();
            foreach ($this->result as $kodePegawai => $group) {
                PointTransactions::create([
                    'transaction_id' => $transactionID,
                    'quartal' => 1,
                    'year' => Carbon::parse($this->start_period)->year,
                    'point_type' => 'technician',
                    'kode_pegawai' => $kodePegawai,
                    'redeemed_by' => Auth::id(),
                    'from_date' => $this->start_period,
                    'to_date' => $this->end_period,
                    'valid_points' => $group->sum('point'),
                    'invalid_points' => 0,
                    'total_points' => $group->sum('point'),
                    'status' => 1 // confirmation
                ]);
            }

            $points->update([
                'redeemed_status' => 1,
                'redeemed_date' => now()
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error(now() . ': Error saat validasi data - ' . $e->getMessage());
            return $this->dispatch('swal', title: 'Error', text: 'Terjadi kesalahan: ' . $e->getMessage(), icon: 'error');
        }

        $this->step = 3;
        $this->summary($transactionID);
    }

    public function summary($transactionID)
    {
        $query = PointTransactions::with('pegawai', 'redeemedby')
            ->where('transaction_id', $transactionID)->get();

        if (!$query) {
            dd('gagal');
        }

        $this->result = $query;
    }

    public function processRedeem($transactionID)
    {
        $this->transactionID = $transactionID;

        $points = TechnicianPoints::whereBetween('created_at', [$this->start_period, $this->end_period])
            ->where('is_redeemable', 1);

        $trans = PointTransactions::where('transaction_id', $this->transactionID);

        try {
            DB::beginTransaction();

            $points->update([
                'redeemed_status' => 2, // diajukan ke hrd
            ]);


            $trans->update([
                'status' => 2,
            ]);

            DB::commit();

            // Refresh status display by reloading transaction data
            $this->summary($this->transactionID);
            return $this->dispatch('swal', title: 'Berhasil', text: 'Status pengajuan telah berubah menjadi menunggu persetujuan HRD', icon: 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error(now() . ': Error saat mengajukan pengajuan poin - transID: ' . $this->transactionID . ' - ' . $e->getMessage());
            return $this->dispatch('swal', title: 'Error', text: 'Terjadi kesalahan: ' . $e->getMessage(), icon: 'error');
        }
    }

    public function render()
    {
        return view('livewire.handler.point.technician.redeem', [
            'results' => $this->result,
        ]);
    }
}
