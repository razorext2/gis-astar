<?php

namespace App\Livewire\Handler\Driver;

use App\Models\Driver;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AssignTo extends Component
{
    public Driver $driver;

    #[Validate('required|integer', message: [
        'kode_pegawai.required' => 'Driver wajib dipilih!',
        'kode_pegawai.integer' => 'Kode Jari harus berupa angka!',
    ])]
    public int $kode_pegawai;

    public function mount(int $id): void
    {
        $this->driver = Driver::findOrFail($id);
    }

    public function assign()
    {
        $this->validate();

        try {
            $this->driver->update([
                'status' => 5,
                'kode_pegawai' => $this->kode_pegawai,
                'assign_by' => auth()->user()->id,
            ]);

            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Laporan berhasil di assgin ke <b>' . $this->driver->user->name . '</b>');
            $this->dispatch('redirectRoute', route('driver.index'));
        } catch (\Exception $e) {
            $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'Laporan gagal di assgin ke <b>' . $this->driver->user->name . '</b> ' . $e->getMessage());
        }
    }

    public function render()
    {
        $drivers = User::role('Driver')
            ->get();

        return view('livewire.handler.driver.assign-to', [
            'data' => $this->driver,
            'drivers' => $drivers,
        ]);
    }
}
