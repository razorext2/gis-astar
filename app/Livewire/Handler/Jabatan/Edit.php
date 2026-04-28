<?php

namespace App\Livewire\Handler\Jabatan;

/** Goal: Handle Jabatan update form, Caller: resources/views/dashboard/jabatan/edit.blade.php, Deps: Jabatan, Division, Placement, User */

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Division;
use App\Models\Jabatan;
use App\Models\Placement;
use App\Models\User;
use Livewire\Component;

class Edit extends Component
{
    use HandlesErrors;

    public $jabatanId;

    public $nama_jabatan;

    public $divisi;

    public $penempatan;

    public $supervisor_id;

    public $search_supervisor = '';

    public function mount(Jabatan $jabatan)
    {
        $this->jabatanId = $jabatan->id;
        $this->nama_jabatan = $jabatan->nama_jabatan;
        $this->divisi = $jabatan->divisi;
        $this->penempatan = $jabatan->penempatan;
        $this->supervisor_id = $jabatan->supervisor_id;

        if ($this->supervisor_id) {
            $this->search_supervisor = User::find($this->supervisor_id)?->name;
        }
    }

    public function save()
    {
        $this->validate([
            'nama_jabatan' => 'required|string|max:255',
            'divisi' => 'nullable|exists:tb_division,id',
            'penempatan' => 'nullable|exists:tb_placement,id',
            'supervisor_id' => 'nullable|exists:users,id',
        ]);

        $this->runSafely(function () {
            $jabatan = Jabatan::findOrFail($this->jabatanId);
            $jabatan->update([
                'nama_jabatan' => $this->nama_jabatan,
                'divisi' => $this->divisi,
                'penempatan' => $this->penempatan,
                'supervisor_id' => $this->supervisor_id,
            ]);

            session()->flash('status', 'Berhasil mengubah data Jabatan');

            return redirect()->route('jabatan.index');
        }, 'Error saat mengubah data Jabatan', [
            'user_id' => auth()->id(),
            'action' => 'update jabatan.',
        ]);
    }

    public function render()
    {
        $users = User::query()
            ->select(['id', 'name', 'kode_pegawai', 'is_active'])
            ->where('is_active', true)
            ->when($this->search_supervisor, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search_supervisor.'%')
                        ->orWhere('kode_pegawai', 'like', '%'.$this->search_supervisor.'%');
                });
            })
            ->orderBy('name')
            ->limit(10)
            ->get();

        return view('livewire.handler.jabatan.edit', [
            'divisions' => Division::select(['id', 'nama_divisi'])->get(),
            'placements' => Placement::select(['id', 'penempatan'])->get(),
            'users' => $users,
        ]);
    }
}
