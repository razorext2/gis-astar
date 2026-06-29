<?php

/** Goal: Validate and approve/reject sales reports, Caller: Index (SalesTable) / Detail View, Deps: App\Models\Sales, App\Livewire\Concerns\HandlesErrors */

namespace App\Livewire\Handler\Sales;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Sales;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ValidateSales extends Component
{
    use HandlesErrors, WithFileUploads;

    public $showModal = false;

    public $showDetail = false;

    public $label;

    public $id;

    public $rejectionReason;

    public $step = 1;

    public $data;

    public $customer_telp;

    public $customer_name;

    public $customer_address;

    public $customer_make_order;

    public $gives_phone_number;

    public $order_notes;

    public $proof_pic;

    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:100',
            'customer_address' => 'required|string|max:255',
            'customer_make_order' => 'required|boolean',
            'gives_phone_number' => 'required|boolean',
            'order_notes' => 'required|string',
            'proof_pic' => $this->gives_phone_number ? 'required|image|max:2048' : 'nullable|image|max:2048',
        ];
    }

    public function mount(?int $id = null): void
    {
        if ($id !== null) {
            $this->loadData($id);
        }
    }

    #[On('openSalesValidateModal')]
    public function openModal(int $id): void
    {
        $this->reset([
            'customer_name',
            'customer_address',
            'customer_make_order',
            'gives_phone_number',
            'order_notes',
            'proof_pic',
            'rejectionReason',
            'step',
            'customer_telp',
        ]);
        $this->resetValidation();
        $this->loadData($id);
        
        if ($this->label !== null) {
            $this->step = 2;
            $this->showDetail = false;
        } else {
            $this->showDetail = true;
        }
        
        $this->showModal = true;
    }

    private function loadData(int $id): void
    {
        $this->id = $id;
        $this->data = Sales::with(['pegawaiRelasi', 'photoCollectRelasi'])->find($id);

        $this->checkData($this->data);

        $this->customer_name = $this->data->customer_name;
        $this->customer_address = $this->data->lokasi;
        $this->gives_phone_number = $this->data->gives_phone_number;

        $this->customer_telp = str_starts_with($this->data->customer_telp, '08')
            ? '628'.substr($this->data->customer_telp, 2)
            : $this->data->customer_telp;
    }

    public function toValidation(): void
    {
        $this->step = 2;
    }

    public function toRejection(): void
    {
        $this->step = 3;
    }

    public function confirmValidation(): mixed
    {
        $this->validate();

        $this->checkPermission();

        $query = Sales::find($this->id);

        $this->checkData($query);

        return $this->runSafely(function () use ($query) {
            DB::transaction(function () use ($query) {
                // upload file if exists
                $fileName = $query->proof_picture;
                if ($this->proof_pic) {
                    $fileName = 'bukti_followup'.Str::random(10).'.'.$this->proof_pic->extension();
                    $this->proof_pic->storeAs('public/sales/proof', $fileName);
                }

                // update status laporan
                $query->update([
                    'status' => 1,
                    'validate_by' => Auth::id(),
                    'customer_name' => $this->customer_name,
                    'customer_address' => $this->customer_address,
                    'customer_make_order' => $this->customer_make_order,
                    'gives_phone_number' => $this->gives_phone_number,
                    'order_notes' => $this->order_notes,
                    'proof_picture' => $fileName,
                ]);
            });

            $this->resetModal();
            $this->dispatch('swal', title: 'Berhasil', text: 'Data telah dikonfirmasi', icon: 'success');

            if ($this->label !== null) {
                return $this->redirectRoute('sales.show', ['sale' => $this->id], navigate: true);
            }

            return $this->dispatch('pg:eventRefresh-SalesTable');
        }, 'Terjadi kesalahan saat mengonfirmasi data sales.', [
            'action' => 'confirm sales validation',
            'sales_id' => $this->id,
            'user_id' => auth()->id(),
        ]);
    }

    public function confirmRejection(): mixed
    {
        $this->checkPermission();

        $query = Sales::find($this->id);

        $this->checkData($query);

        return $this->runSafely(function () use ($query) {
            $query->update([
                'status' => 2,
                'validate_by' => Auth::id(),
                'notes' => $this->rejectionReason,
            ]);

            $this->resetModal();
            $this->dispatch('swal', title: 'Sukses!', text: 'Data berhasil ditolak', icon: 'success');

            if ($this->label !== null) {
                return $this->redirectRoute('sales.show', ['sale' => $this->id], navigate: true);
            }

            return $this->dispatch('pg:eventRefresh-SalesTable');
        }, 'Terjadi kesalahan saat menolak data sales.', [
            'action' => 'reject sales validation',
            'sales_id' => $this->id,
            'user_id' => auth()->id(),
        ]);
    }

    public function resetModal(): void
    {
        $this->showModal = false;
        $this->reset([
            'customer_name',
            'customer_address',
            'customer_make_order',
            'gives_phone_number',
            'order_notes',
            'proof_pic',
            'rejectionReason',
            'step',
            'customer_telp',
            'showDetail',
        ]);
        $this->resetValidation();
    }

    public function checkPermission(): void
    {
        if (Auth::user()->cannot('sales-approve')) {
            abort(403);
        }
    }

    public function checkData($query): void
    {
        if (! $query) {
            $this->dispatch('swal', title: 'Data tidak ditemukan', text: 'Data tidak ditemukan', icon: 'error');
        }
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.handler.sales.validate-sales');
    }
}
