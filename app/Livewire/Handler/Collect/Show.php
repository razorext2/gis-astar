<?php

/** Goal: Handling detail view and approval flow for collector reports, Caller: dashboard/collect/detail, Deps: Collector, CollectTask, HandlesErrors */

namespace App\Livewire\Handler\Collect;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\CollectIdyPpn;
use App\Models\Collector;
use App\Models\CollectTask;
use App\Models\CollectTaskPpn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Show extends Component
{
    use HandlesErrors;

    #[Locked]
    public int $id;

    public $data;

    public bool $showDenyModal = false;

    public bool $showRevisionModal = false;

    public string $notes = '';

    public function mount(int $id): void
    {
        $this->id = $id;
        $this->loadData();
    }

    public function loadData(): void
    {
        $this->data = Collector::with([
            'pegawaiRelasi',
            'photoCollectRelasi',
            'collectTaskRelasi',
            'collectTaskPpnRelasi',
            'collectIdyPpnRelasi',
            'validatedBy',
        ])->findOrFail($this->id);
    }

    public function confirm(): void
    {
        if (Auth::user()->cannot('collect-approve')) {
            $this->dispatch('swal', title: 'Forbidden', text: 'Anda tidak memiliki izin untuk menyetujui laporan.', icon: 'error');

            return;
        }

        $task = $this->getMasterTask();

        if (! $task) {
            $this->dispatch('swal', title: 'Error', text: 'Data tagihan master tidak ditemukan.', icon: 'error');

            return;
        }

        if ($task->remaining_bill < $this->data->payment_amount) {
            $this->dispatch('swal', title: 'Error', text: 'Jumlah pembayaran melebihi sisa tagihan.', icon: 'error');

            return;
        }

        $this->runSafely(function () use ($task) {
            DB::transaction(function () use ($task) {
                $this->data->update([
                    'status' => 1,
                    'validate_by' => Auth::id(),
                    'validated_at' => now(),
                ]);

                $task->update([
                    'bill_status' => 1,
                    'remaining_bill' => $task->remaining_bill - $this->data->payment_amount,
                ]);
            });

            $this->loadData();
            $this->dispatch('swal', title: 'Berhasil', text: 'Laporan berhasil dikonfirmasi.', icon: 'success');
        }, 'Gagal mengonfirmasi laporan.');
    }

    public function deny(): void
    {
        if (Auth::user()->cannot('collect-approve')) {
            $this->dispatch('swal', title: 'Forbidden', text: 'Anda tidak memiliki izin untuk menolak laporan.', icon: 'error');

            return;
        }

        $this->validate([
            'notes' => 'required|string|min:5',
        ]);

        $this->runSafely(function () {
            DB::transaction(function () {
                $task = $this->getMasterTask();

                if ($task) {
                    $task->update([
                        'assign_by' => null,
                        'assign_to' => null,
                        'bill_status' => 1,
                    ]);
                }

                $this->data->update([
                    'status' => 3,
                    'notes' => $this->notes,
                    'validate_by' => Auth::id(),
                    'validated_at' => now(),
                ]);
            });

            $this->showDenyModal = false;
            $this->notes = '';
            $this->loadData();
            $this->dispatch('swal', title: 'Berhasil', text: 'Laporan telah ditolak.', icon: 'success');
        }, 'Gagal menolak laporan.');
    }

    public function revision(): void
    {
        if (Auth::user()->cannot('collect-approve')) {
            $this->dispatch('swal', title: 'Forbidden', text: 'Anda tidak memiliki izin untuk meminta revisi.', icon: 'error');

            return;
        }

        if ($this->data->total_revision >= 1) {
            $this->dispatch('swal', title: 'Gagal', text: 'Laporan sudah mencapai batas maksimal revisi (1x).', icon: 'warning');

            return;
        }

        $this->validate([
            'notes' => 'required|string|min:5',
        ]);

        $this->runSafely(function () {
            DB::transaction(function () {
                $this->data->update([
                    'status' => 4,
                    'notes' => $this->notes,
                    'validate_by' => Auth::id(),
                    'total_revision' => $this->data->total_revision + 1,
                    'validated_at' => now(),
                ]);
            });

            $this->showRevisionModal = false;
            $this->notes = '';
            $this->loadData();
            $this->dispatch('swal', title: 'Berhasil', text: 'Permintaan revisi telah dikirim.', icon: 'success');
        }, 'Gagal mengirim permintaan revisi.');
    }

    private function getMasterTask()
    {
        return match ($this->data->bill_type) {
            'idcnonppn' => CollectTask::where('no_sr', $this->data->no_sr)->first(),
            'idcppn' => CollectTaskPpn::where('tax_invoice', $this->data->no_sr)->first(),
            'idyppn' => CollectIdyPpn::where('tax_invoice', $this->data->no_sr)->first(),
            default => null,
        };
    }

    public function render()
    {
        return view('livewire.handler.collect.show');
    }
}
