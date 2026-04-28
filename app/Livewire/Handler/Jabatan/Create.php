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

    public $supervisor_id;

    public $search_supervisor = '';

    public function save()
    {
        $this->validate([
            'nama_jabatan' => 'required|string|max:255',
            'divisi' => 'nullable|exists:tb_division,id',
            'penempatan' => 'nullable|exists:tb_placement,id',
            'supervisor_id' => 'nullable|exists:users,id',
        ]);

        $this->runSafely(function () {
            Jabatan::create([
                'nama_jabatan' => $this->nama_jabatan,
                'divisi' => $this->divisi,
                'penempatan' => $this->penempatan,
                'supervisor_id' => $this->supervisor_id,
            ]);

            session()->flash('status', 'Berhasil menambah data Jabatan');

            return redirect()->route('jabatan.index');
        }, 'Error saat menambah data Jabatan', [
            'user_id' => auth()->id(),
            'action' => 'add jabatan.',
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

        return view('livewire.handler.jabatan.create', [
            'divisions' => Division::select(['id', 'nama_divisi'])->get(),
            'placements' => Placement::select(['id', 'penempatan'])->get(),
            'users' => $users,
        ]);
    }
}
