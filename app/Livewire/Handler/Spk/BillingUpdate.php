<?php

namespace App\Livewire\Handler\Spk;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Invoice;
use App\Models\Spk\SpkMain;
use Livewire\Component;

class BillingUpdate extends Component
{
    use HandlesErrors;

    public ?string $id;

    public ?string $nomor_tagihan = null;

    public ?string $tipe_tagihan = null;

    public ?bool $status_nomor_tagihan = null;

    public ?string $nama_customer = null;

    public ?string $nomor_tagihan_baru = null;

    public $spk_data;

    protected $rules = [
        'nomor_tagihan' => 'required|min:8|integer',
        'tipe_tagihan' => 'required:min:4|string',
    ];

    protected $messages = [
        'nomor_tagihan.required' => 'Nomor tagihan harus diisi.',
        'nomor_tagihan.min' => 'Nomor tagihan minimal 8 karakter.',
        'nomor_tagihan.integer' => 'Nomor tagihan harus berupa angka.',
        'tipe_tagihan.required' => 'Tipe tagihan harus diisi.',
        'tipe_tagihan.min' => 'Tipe tagihan minimal 4 karakter.',
        'tipe_tagihan.integer' => 'Tipe tagihan harus berupa string.',
    ];

    public function mount($id)
    {
        $this->id = $id;

        $this->spk_data = SpkMain::with('invoice')
            ->findOrFail($id);

        $this->nomor_tagihan = $this->spk_data->nomor_tagihan;
        $this->status_nomor_tagihan = $this->spk_data->status_nomor_tagihan;
        $this->tipe_tagihan = $this->spk_data->tipe_tagihan;
    }

    public function search()
    {
        // validasi data
        $this->validate();

        // cari data berdasarkan model tipe tagihan
        $model = $this->getModelByTipeTagihan($this->tipe_tagihan, $this->nomor_tagihan);

        // cek apakah data ada
        if (! $model->exists()) {
            $model = Invoice::where('no_faktur_pajak', $this->nomor_tagihan)
                ->where('tipe_tagihan', $this->tipe_tagihan);

            if (! $model->exists()) {
                $this->clear();

                return $this->dispatch(
                    event: 'swal',
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Nomor tagihan:'.$this->nomor_tagihan.' tidak ditemukan. Silahkan tambah terlebih dahulu di Invoice, atau buat penagihannya.'
                );
            }

            $this->nama_customer = $model->first()->nama_customer;
            $this->nomor_tagihan_baru = $model->first()->no_faktur_pajak;
        }

        $field = match ($this->tipe_tagihan) {
            'idcnonppn' => 'no_sr',
            'idcppn' => 'tax_invoice',
            'idyppn' => 'tax_invoice',
            default => null,
        };

        $this->nama_customer = $model->first()->customer_name;
        $this->nomor_tagihan_baru = $model->first()->$field;
    }

    public function assign()
    {
        $policy = match ($this->tipe_tagihan) {
            'idcnonppn' => 'updateNoTagihanIdcNonPpn',
            'idcppn' => 'updateNoTagihanIdcPpn',
            'idyppn' => 'updateNoTagihanIdyPpn',
        };

        // check authorization
        $this->authorize($policy, SpkMain::class);

        $this->runSafely(function () {
            // update nomor tagihan di spk
            $this->spk_data->update([
                'tipe_tagihan' => $this->tipe_tagihan,
                'nomor_tagihan' => $this->nomor_tagihan_baru,
                'status_nomor_tagihan' => 1, // sudah diassign
                'status' => 4, // penagihan
                'updated_by' => auth()->id(),
                'no_tagihan_updated_by' => auth()->id(),
            ]);

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
            'form' => [
                'id_spk' => $this->id,
                'nomor_tagihan' => $this->nomor_tagihan_baru,
                'nama_customer' => $this->nama_customer,
            ],
            'user_id' => auth()->id(),
        ]);
    }

    protected function getModelByTipeTagihan($tipe_tagihan, $nomor_tagihan)
    {
        $model = match ($tipe_tagihan) {
            'idcnonppn' => [
                'model' => '\App\Models\CollectTask',
                'field' => 'no_sr',
            ],
            'idcppn' => [
                'model' => '\App\Models\CollectTaskPpn',
                'field' => 'no_sr',
            ],
            'idyppn' => [
                'model' => '\App\Models\CollectIdyPpn',
                'field' => 'no_sr',
            ],
            default => null,
        };

        return $model['model']::where($model['field'], $nomor_tagihan);
    }

    protected function removeAllUnusedCharacter($value)
    {
        $value = preg_replace('/[^\p{L}\p{N}]+/u', '', $value);
        $value = strtolower($value);

        return $value;
    }

    public function clear()
    {
        $this->nomor_tagihan = null;
        $this->nama_customer = null;
        $this->nomor_tagihan_baru = null;
    }

    public function render()
    {
        return view('livewire.handler.spk.billing-update');
    }
}
