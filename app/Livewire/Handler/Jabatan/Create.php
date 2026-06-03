<?php

namespace App\Livewire\Handler\Jabatan;

/** Goal: Handle Jabatan creation form, Caller: resources/views/dashboard/jabatan/add.blade.php, Deps: Jabatan, Division, Placement, User */

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Division;
use App\Models\Jabatan;
use App\Models\Placement;
use App\Models\User;
use Livewire\Component;

class Create extends Component
{
    use HandlesErrors;

    public $nama_jabatan;

    public $divisi;

    public $penempatan;

    public array $supervisor_ids = [];

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
            $jabatan = Jabatan::create([
                'nama_jabatan' => $this->nama_jabatan,
                'divisi' => $this->divisi,
                'penempatan' => $this->penempatan,
            ]);

            if (!empty($this->supervisor_ids)) {
                $jabatan->supervisors()->sync($this->supervisor_ids);
            }

            session()->flash('status', 'Berhasil menambah data Jabatan');

            return redirect()->route('jabatan.index');
        }, 'Error saat menambah data Jabatan', [
            'user_id' => auth()->id(),
            'action' => 'add jabatan.',
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

        return view('livewire.handler.jabatan.create', [
            'divisions' => Division::select(['id', 'nama_divisi'])->get(),
            'placements' => Placement::select(['id', 'penempatan'])->get(),
            'allUsers' => $allUsers,
        ]);
    }
}
