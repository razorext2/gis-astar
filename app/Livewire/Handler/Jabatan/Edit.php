<?php

namespace App\Livewire\Handler\Jabatan;

/** Goal: Handle Jabatan update form, Caller: resources/views/dashboard/jabatan/edit.blade.php, Deps: Jabatan, Division, Placement, User */

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Division;
use App\Models\Jabatan;
use App\Models\Placement;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Edit extends Component
{
    use HandlesErrors, WithPagination;

    public $jabatanId;

    public $nama_jabatan;

    public $divisi;

    public $penempatan;

    public array $supervisor_ids = [];

    public function mount(Jabatan $jabatan)
    {
        $this->jabatanId = $jabatan->id;
        $this->nama_jabatan = $jabatan->nama_jabatan;
        $this->divisi = $jabatan->divisi;
        $this->penempatan = $jabatan->penempatan;
        $this->supervisor_ids = $jabatan->supervisors()->pluck('users.id')->toArray();
    }

    public function save()
    {
        $this->validate([
            'nama_jabatan' => 'required|string|max:255',
            'divisi' => 'nullable|exists:tb_division,id',
            'penempatan' => 'nullable|exists:tb_placement,id',
            'supervisor_ids' => 'nullable|array',
            'supervisor_ids.*' => 'exists:users,id',
        ]);

        $this->runSafely(function () {
            $jabatan = Jabatan::findOrFail($this->jabatanId);
            $jabatan->update([
                'nama_jabatan' => $this->nama_jabatan,
                'divisi' => $this->divisi,
                'penempatan' => $this->penempatan,
            ]);

            $jabatan->supervisors()->sync($this->supervisor_ids);

            session()->flash('status', 'Berhasil mengubah data Jabatan');

            return redirect()->route('jabatan.index');
        }, 'Error saat mengubah data Jabatan', [
            'user_id' => auth()->id(),
            'action' => 'update jabatan.',
        ]);
    }

    public function render()
    {
        $allUsers = User::query()
            ->select(['id', 'name', 'kode_pegawai', 'is_active'])
            ->where('is_active', true)
            ->with('pegawai')
            ->orderBy('name')
            ->get();

        $jabatan = Jabatan::findOrFail($this->jabatanId);
        $employees = $jabatan->pegawai()->with('userRelasi')->paginate(5);

        return view('livewire.handler.jabatan.edit', [
            'divisions' => Division::select(['id', 'nama_divisi'])->get(),
            'placements' => Placement::select(['id', 'penempatan'])->get(),
            'allUsers' => $allUsers,
            'employees' => $employees,
        ]);
    }
}
