<?php

namespace App\Livewire\Handler\Driver;

use App\Models\Driver;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AssignAdd extends Component
{
    #[Validate('required|string|min:11|max:11', message: [
        'no_sr.required' => 'No. SR wajib diisi!',
        'no_sr.min' => 'No. SR minimal 11 karakter!',
        'no_sr.max' => 'No. SR maksimal 11 karakter!',
    ])]
    public string $no_sr = '';

    #[Validate('required|string|min:6|max:6', message: [
        'pt_type.required' => 'Tipe kunjungan wajib diisi!',
        'pt_type.min' => 'Tipe kunjungan minimal 6 karakter!',
        'pt_type.max' => 'Tipe kunjungan maksimal 6 karakter!',
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

    public function fetchSR()
    {
        // validasi field no. sr
        $this->validateOnly('no_sr');

        // tampilkan loading popup
        $this->dispatch('loadingProgress', message: 'Mencari data...');

        // akses API
        $response = Http::get('https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchSR&NomorPermintaanJual=' . $this->no_sr);

        // jika status = error
        if ($response['status'] == 'error') {
            return $this->dispatch('swal', icon: 'error', text: $response['message'], title: 'Gagal');
        }

        // tutup loading popup
        $this->dispatch('loadingClose');

        $data = $response['data'][0];
        $this->pt_name = $data['NamaCustomer'];
        $this->pt_address = $data['AlamatContact'];
        $this->assign_date = Carbon::now()->addDays(1)->format('Y-m-d');
    }

    public function store()
    {
        // validasi input
        $this->validate();

        $assign_date = $this->assign_date;

        dd($assign_date);

        // tampilkan pesan loading
        $this->dispatch('loadingProgress', message: 'Mengirim data...');

        try {
            $driver = Driver::create([
                'no_sr' => $this->no_sr,
                'tipe_kunjungan' => $this->pt_type,
                'title' => $this->pt_name,
                'lokasi' => $this->pt_address,
                'assign_date' => $this->assign_date,
                'assign_by' => auth()->user()->id,
                'status' => 4,
            ]);

            if ($driver) {
                $this->reset();

                return $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data berhasil disimpan.');
            }
        } catch (\Exception $e) {
            return $this->dispatch('swal', icon: 'error', text: $e->getMessage(), title: 'Gagal');
        }
    }

    public function render()
    {
        return view('livewire.handler.driver.assign-add');
    }
}
