<?php

namespace App\Livewire\Handler\Sales;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Sales;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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

    #[Validate('required|string|max:100')]
    public $customer_name;

    #[Validate('required|string|max:255')]
    public $customer_address;

    #[Validate('required|boolean')]
    public $customer_make_order;

    #[Validate('required|string')]
    public $order_notes;

    #[Validate('required|image|max:2048')]
    public $proof_pic;

    public function mount($id)
    {
        $this->data = Sales::find($id);

        $this->checkData($this->data);

        $this->customer_name = $this->data->customer_name;
        $this->customer_address = $this->data->lokasi;

        $this->customer_telp = str_starts_with($this->data->customer_telp, '08')
            ? '628'.substr($this->data->customer_telp, 2)
            : $this->data->customer_telp;
    }

    public function toQuestionnaire()
    {
        $this->step = 2;
    }

    public function toRejection()
    {
        $this->step = 3;
    }

    public function confirmQuestionnaire()
    {
        $this->validate();

        $this->checkPermission();

        $query = Sales::find($this->id);

        $this->checkData($query);

        return $this->runSafely(function () use ($query) {
            DB::transaction(function () use ($query) {
                // upload file
                $fileName = 'bukti_followup'.Str::random(10).'.'.$this->proof_pic->extension();

                $this->proof_pic->storeAs('public/sales/proof', $fileName);

                // update status laporan
                $query->update([
                    'status' => 1,
                    'validate_by' => Auth::id(),
                    'customer_name' => $this->customer_name,
                    'customer_address' => $this->customer_address,
                    'customer_make_order' => $this->customer_make_order,
                    'order_notes' => $this->order_notes,
                    'proof_picture' => $fileName,
                ]);
            });

            $this->resetModal();
            $this->dispatch('swal', title: 'Berhasil', text: 'Data telah dikonfirmasi', icon: 'success');

            return $this->dispatch('redirectRoute', route('sales.index'));
        }, 'Terjadi kesalahan saat mengonfirmasi data sales.', [
            'action' => 'confirm sales validation',
            'sales_id' => $this->id,
            'user_id' => auth()->id(),
        ]);
    }

    public function confirmRejection()
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

            return $this->dispatch('redirectRoute', route('sales.index'));
        }, 'Terjadi kesalahan saat menolak data sales.', [
            'action' => 'reject sales validation',
            'sales_id' => $this->id,
            'user_id' => auth()->id(),
        ]);
    }

    public function resetModal()
    {
        $this->showModal = false;
        $this->step = 1;
    }

    public function checkPermission()
    {
        if (Auth::user()->cannot('sales-approve')) {
            return abort(403);
        }
    }

    public function checkData($query)
    {
        if (! $query) {
            return $this->dispatch('swal', title: 'Data tidak ditemukan', text: 'Data tidak ditemukan', icon: 'error');
        }
    }

    public function render()
    {
        return view('livewire.handler.sales.validate-sales');
    }
}
