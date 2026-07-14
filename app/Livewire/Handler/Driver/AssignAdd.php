<?php

/** Goal: Handle driver assignment report creation, Caller: resources/views/dashboard/driver/assign-add.blade.php, Deps: App\Models\Driver */

namespace App\Livewire\Handler\Driver;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Driver;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AssignAdd extends Component
{
    use HandlesErrors;

    #[Validate('required|string|size:11', message: [
        'no_sr.required' => 'No. SR wajib diisi!',
        'no_sr.size' => 'No. SR harus berukuran 11 karakter!',
    ])]
    public string $no_sr = '';

    #[Validate('required|string|min:3|max:10', message: [
        'tipe_tagihan.required' => 'Tipe tagihan wajib diisi!',
        'tipe_tagihan.min' => 'Tipe tagihan minimal 3 karakter!',
        'tipe_tagihan.max' => 'Tipe tagihan maksimal 10 karakter!',
    ])]
    public string $tipe_tagihan = '';

    #[Validate('required|string|size:6', message: [
        'pt_type.required' => 'Tipe kunjungan wajib diisi!',
        'pt_type.size' => 'Tipe kunjungan harus berukuran 6 karakter!',
    ])]
    public string $pt_type = '';

    #[Validate('required|string', message: [
        'pt_name.required' => 'Nama PT. wajib diisi!',
    ])]
    public string $pt_name = '';

    #[Validate('required|string', message: [
        'pt_address.required' => 'Alamat PT. wajib diisi!',
    ])]
    public string $pt_address = '';

    #[Validate('required|date', message: [
        'assign_date.required' => 'Tanggal kunjungan wajib diisi!',
    ])]
    public string $assign_date = '';

    public function mount(): void
    {
        $this->assign_date = Carbon::now()->format('Y-m-d');
    }

    public function fetchSR(): void
    {
        $this->validateOnly('no_sr');
        $this->validateOnly('tipe_tagihan');

        $api_fetch = match ($this->tipe_tagihan) {
            'idcppn' => 'fetchSR3',
            'idcnon' => 'fetchSR',
            default => throw new \InvalidArgumentException('Tipe tagihan tidak valid'),
        };

        $this->dispatch('loadingProgress', message: 'Mencari data...');

        $response = Http::get('https://indodacin.nusa.net.id/web/finger/secureapi.php', [
            'tipe' => $api_fetch,
            'NomorPermintaanJual' => $this->no_sr,
        ]);

        if ($response['status'] == 'error') {
            $this->dispatch('swal', icon: 'error', text: $response['message'], title: 'Gagal');
            return;
        }

        $this->dispatch('loadingClose');

        $data = $response['data'][0];
        $this->pt_name = $data['NamaCustomer'];
        $this->pt_address = $data['AlamatContact'];
    }

    public function store(): void
    {
        $this->validate();

        $this->dispatch('loadingProgress', message: 'Mengirim data...');

        $this->runSafely(function () {
            $driver = Driver::create([
                'no_sr' => $this->no_sr,
                'tipe_tagihan' => $this->tipe_tagihan,
                'tipe_kunjungan' => $this->pt_type,
                'title' => $this->pt_name,
                'lokasi' => $this->pt_address,
                'assign_date' => $this->assign_date,
                'assign_by' => auth()->id(),
                'status' => 4,
            ]);

            if ($driver) {
                $this->reset();

                $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data berhasil disimpan.');
            }
        }, 'Gagal menyimpan data penugasan.', [
            'user_id' => auth()->id(),
            'no_sr' => $this->no_sr,
        ]);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.handler.driver.assign-add');
    }
}
