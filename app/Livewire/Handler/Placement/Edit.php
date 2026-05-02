<?php

/** Goal: Handle form edit penempatan, Caller: dashboard.placement.edit blade, Deps: Placement model */

namespace App\Livewire\Handler\Placement;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Placement;
use Livewire\Component;

class Edit extends Component
{
    use HandlesErrors;

    public Placement $placement;

    public string $kode_penempatan = '';

    public string $penempatan = '';

    public string $alamat = '';

    public string $longitude = '';

    public string $latitude = '';

    public int $radius = 100;

    public string $restrict_app = '';

    public array $hrd_ids = [];

    public array $management_ids = [];

    public function mount(Placement $placement): void
    {
        $this->placement = $placement;
        $this->kode_penempatan = $placement->kode_penempatan;
        $this->penempatan = $placement->penempatan;
        $this->alamat = $placement->alamat;
        $this->longitude = (string) $placement->longitude;
        $this->latitude = (string) $placement->latitude;
        $this->radius = (int) $placement->radius;
        $this->restrict_app = $placement->restrict_app ?? '';
        
        $this->hrd_ids = $placement->hrds()->pluck('users.id')->toArray();
        $this->management_ids = $placement->managements()->pluck('users.id')->toArray();
    }

    protected function rules(): array
    {
        return [
            'kode_penempatan' => 'required|string|max:50|unique:tb_placement,kode_penempatan,'.$this->placement->id,
            'penempatan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'radius' => 'required|integer|min:10|max:150',
            'restrict_app' => 'required|in:y,t',
            'hrd_ids' => 'nullable|array',
            'hrd_ids.*' => 'exists:users,id',
            'management_ids' => 'nullable|array',
            'management_ids.*' => 'exists:users,id',
        ];
    }

    protected array $messages = [
        'kode_penempatan.required' => 'Kode penempatan wajib diisi.',
        'kode_penempatan.unique' => 'Kode penempatan sudah terdaftar.',
        'penempatan.required' => 'Nama penempatan wajib diisi.',
        'alamat.required' => 'Alamat wajib diisi.',
        'longitude.required' => 'Longitude wajib diisi — klik peta untuk menentukan lokasi.',
        'longitude.numeric' => 'Longitude harus berupa angka.',
        'latitude.required' => 'Latitude wajib diisi — klik peta untuk menentukan lokasi.',
        'latitude.numeric' => 'Latitude harus berupa angka.',
        'radius.min' => 'Radius minimal 10 meter.',
        'radius.max' => 'Radius maksimal 150 meter.',
        'restrict_app.required' => 'Pembatasan akses wajib dipilih.',
        'restrict_app.in' => 'Nilai pembatasan akses tidak valid.',
    ];

    public function save(): void
    {
        $this->validate();

        $this->runSafely(function () {
            $this->placement->update([
                'kode_penempatan' => $this->kode_penempatan,
                'penempatan' => $this->penempatan,
                'alamat' => $this->alamat,
                'longitude' => $this->longitude,
                'latitude' => $this->latitude,
                'radius' => $this->radius,
                'restrict_app' => $this->restrict_app,
            ]);

            $this->placement->hrds()->sync($this->hrd_ids);
            $this->placement->managements()->sync($this->management_ids);

            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Lokasi Berhasil Diperbarui');

            $this->redirect(route('placement.index'), navigate: true);
        }, 'Gagal memperbarui lokasi.', [
            'user_id' => auth()->id(),
            'action' => 'update placement',
        ]);
    }

    public function render(): \Illuminate\View\View
    {
        $users = \App\Models\User::has('pegawai')->orderBy('name')->get();

        return view('livewire.handler.placement.form', [
            'users' => $users
        ]);
    }
}
