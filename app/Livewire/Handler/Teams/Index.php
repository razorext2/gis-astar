<?php

namespace App\Livewire\Handler\Teams;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    use HandlesErrors;

    public $showMember;

    public $teamMember;

    public ?bool $showModal = false;

    public ?bool $showRemoveMemberModal = false;

    public $team_code = null;

    public $kode_pegawai = null;

    public $newMember = [];

    public $role = null;

    public function showDetail($team_code)
    {
        if ($this->showMember === $team_code) {
            $this->showMember = null;
        } else {
            $this->showMember = $team_code;
            $this->teamMember = TeamMember::where('team_code', $team_code)->get();
        }
    }

    public function addMemberDialog($team_code)
    {
        $this->reset();
        $this->newMember = [];
        $this->showModal = true;
        $this->team_code = $team_code;
        $this->showMember = $team_code;
    }

    public function addMemberProcess()
    {
        $this->runSafely(function () {
            DB::transaction(function () {
                foreach ($this->newMember as $member) {
                    TeamMember::create([
                        'team_code' => $this->team_code,
                        'kode_pegawai' => $member,
                        'user_id' => 222,
                        'role' => $this->role,
                    ]);
                }
            });

            $this->showModal = false;
            $this->reset(['newMember', 'role']);
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Anggota berhasil ditambahkan');
        }, 'Gagal menambahkan anggota tim.', [
            'action' => 'add team members',
            'team_code' => $this->team_code,
            'user_id' => auth()->id(),
        ]);
    }

    #[On('removeMemberModal')]
    public function removeMemberModal($kode_pegawai, $team_code)
    {
        $this->showRemoveMemberModal = true;
        $this->kode_pegawai = $kode_pegawai;
        $this->team_code = $team_code;
    }

    public function removeMemberProcess($kode_pegawai, $team_code)
    {
        $query = TeamMember::where('kode_pegawai', $kode_pegawai)
            ->where('team_code', $team_code)
            ->first();

        if ($query->role == 'Leader') {
            $this->showRemoveMemberModal = false;
            $this->dispatch('swal', icon: 'error', title: 'Error', text: 'Leader tidak bisa dihapus');

            return;
        }

        $this->runSafely(function () use ($query) {
            $query->delete();
            $this->showRemoveMemberModal = false;
            $this->reset(['kode_pegawai', 'team_code']);
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Anggota berhasil dihapus');
        }, 'Gagal menghapus anggota tim.', [
            'action' => 'remove team member',
            'kode_pegawai' => $kode_pegawai,
            'team_code' => $team_code,
            'user_id' => auth()->id(),
        ]);
    }

    public function render()
    {
        if (Auth::user()->hasPermissionTo('all-team')) {
            $teams = Team::all();
        } else {
            $teams = Team::where('team_leader', Auth::user()->kode_pegawai)->get();
        }

        $technicians = User::whereHas('roles', function ($role) {
            $role->where('name', 'Teknisi');
        })
            ->whereDoesntHave('teamMember')
            ->where(function ($query) {
                $query->where('kode_pegawai', 'like', '%'.$this->kode_pegawai.'%')
                    ->orWhere('name', 'like', '%'.$this->kode_pegawai.'%');
            })
            ->limit(5)
            ->get();

        return view('livewire.handler.teams.index', compact('teams', 'technicians'));
    }
}
