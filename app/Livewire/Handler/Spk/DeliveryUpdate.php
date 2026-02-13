<?php

namespace App\Livewire\Handler\Spk;

use App\Livewire\Concerns\HandlesErrors;
use App\Livewire\Forms\Spk\Delivery;
use App\Models\Driver;
use App\Models\Spk\SpkDelivery;
use App\Models\Spk\SpkMain;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class DeliveryUpdate extends Component
{
    use HandlesErrors, WithPagination;

    public Delivery $form;

    public $spk_data = null;

    public ?string $id;

    public ?string $search_supir = null;

    public ?bool $show_customer = false;

    public ?string $nama_customer = null;

    public ?string $alamat_customer = null;

    public function mount($id)
    {
        $this->id = $id;
        $this->spk_data = SpkMain::findOrFail($id);

        if ($this->spk_data->is_using_company_driver) {
            $this->form->via = 'supir';
        }
    }

    public function selectDriver($kode_pegawai, $name)
    {
        $this->form->id_supir = $kode_pegawai;
        $this->form->nama_supir = $name;

        $this->skipRender();
    }

    public function store()
    {
        // check authorization
        $this->authorize('updateInformasiPengiriman', SpkMain::class);

        // validasi form
        $this->form->validate();

        // buat history
        $this->form->history[] = [
            'id' => (string) Str::uuid(),
            'status' => 'Dalam Pengiriman',
            'desc' => 'Pengiriman sudah dijadwalkan.',
            'created_at' => now()->toDateTimeString(),
        ];

        $this->runSafely(function () {
            DB::transaction(function () {
                // tambah history pengiriman
                SpkDelivery::create([
                    'id_spk' => $this->id,
                    'nomor_sr' => $this->form->nomor_sr,
                    'via' => $this->form->via,
                    'partay' => $this->form->partay,
                    'no_container' => $this->form->no_container,
                    'nama_kapal' => $this->form->nama_kapal,
                    'no_plat' => $this->form->no_plat,
                    'nama_supir' => $this->form->nama_supir,
                    'id_supir' => $this->form->id_supir,
                    'no_telp_supir' => $this->form->no_telp_supir,
                    'berat' => $this->form->berat,
                    'etd' => $this->form->etd,
                    'eta' => $this->form->eta,
                    'note' => $this->form->note,
                    'products' => $this->form->products,
                    'history' => $this->form->history,
                ]);

                // assign laporan ke driver jika ada nomor_sr, via supir dan is_using_company_driver == true
                if (! is_null($this->form->nomor_sr) && $this->form->via == 'supir' && $this->spk_data->is_using_company_driver == true) {
                    $driver = Driver::create([
                        'no_sr' => $this->form->nomor_sr,
                        'tipe_tagihan' => $this->spk_data->tipe_tagihan,
                        'kode_pegawai' => $this->form->id_supir,
                        'tipe_kunjungan' => 'ATRBRG',
                        'title' => $this->nama_customer,
                        'lokasi' => $this->alamat_customer,
                        'assign_date' => $this->form->etd,
                        'assign_by' => auth()->user()->id,
                        'status' => 5,
                    ]);

                    if (! $driver) {
                        throw new \Exception('Driver gagal dibuat');
                    }
                }

                // update status spk
                $this->spk_data->update([
                    'status' => 4, // proses penagihan
                ]);
            });

            // reset form
            $this->clearForm();

            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Berhasil menambahkan pengiriman dan assign laporan ke driver.');
        }, 'Gagal menambah data pengiriman', [
            'user_id' => auth()->id(),
            'spk_id' => $this->id,
        ]);
    }

    public function clearForm()
    {
        $this->form->reset();
        $this->search_supir = null;
        $this->show_customer = false;
        $this->nama_customer = null;
        $this->alamat_customer = null;
    }

    public function fetchSR()
    {
        // validasi sr
        $this->validateOnly('form.nomor_sr');

        // cek is_using_company_driver
        if (! $this->spk_data->is_using_company_driver) {
            return $this->dispatch('swal', icon: 'error', text: 'SPK ini tidak dikirim menggunakan Supir Perusahaan.', title: 'Gagal');
        }

        $api_fetch = match ($this->spk_data->tipe_tagihan) {
            'idcppn' => 'fetchSR3',
            'idcnon' => 'fetchSR'
        };

        $response = Http::get('https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe='.$api_fetch.'&NomorPermintaanJual='.$this->form->nomor_sr);

        if ($response['status'] == 'error') {
            return $this->dispatch('swal', icon: 'error', text: $response['message'], title: 'Gagal');
        }

        if ($this->sanitizeAlphaNumeric($response['data'][0]['NamaCustomer']) !== $this->sanitizeAlphaNumeric($this->spk_data->customer['nama_perusahaan'])) {
            $error_message = 'Nama Customer tidak sama dengan data SPK yang ada di sistem!. <br> SPK: <b>'.$this->spk_data->customer['nama_perusahaan'].'</b> <br> SR BSI: <b>'.$response['data'][0]['NamaCustomer'].'</b>';

            return $this->dispatch('swal', icon: 'error', text: $error_message, title: 'Gagal');
        }

        $this->show_customer = true;
        $this->nama_customer = $response['data'][0]['NamaCustomer'];
        $this->alamat_customer = $response['data'][0]['AlamatContact'];
    }

    private function sanitizeAlphaNumeric(string $text): string
    {
        return strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $text));
    }

    public function render()
    {
        $deliveries = SpkDelivery::where('id_spk', $this->id)->paginate(perPage: 4, pageName: 'deliveries');

        $drivers = User::role('Driver')
            ->when($this->search_supir, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search_supir.'%')
                        ->orWhere('kode_pegawai', 'like', '%'.$this->search_supir.'%');
                });
            })
            ->limit(3)
            ->get();

        return view('livewire.handler.spk.delivery-update', [
            'deliveries' => $deliveries,
            'drivers' => $drivers,
        ]);
    }
}
