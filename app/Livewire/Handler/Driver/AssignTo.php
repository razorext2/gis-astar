<?php

namespace App\Livewire\Handler\Driver;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Driver;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AssignTo extends Component
{
    use HandlesErrors;

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

        $this->runSafely(function () {
            $this->driver->update([
                'status' => 5,
                'kode_pegawai' => $this->kode_pegawai,
                'assign_by' => auth()->id(),
            ]);

            // Reload user relationship agar object $this->driver->user tidak null/lawas memanggil relation
            $this->driver->load('user');

            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Laporan berhasil di assign ke <b>'.($this->driver->user->name ?? 'Driver').'</b>');
            $this->dispatch('redirectRoute', route('driver.index'));
        }, 'Gagal meng-assign laporan.', [
            'driver_id' => $this->driver->id,
            'kode_pegawai' => $this->kode_pegawai,
            'user_id' => auth()->id(),
        ]);
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
