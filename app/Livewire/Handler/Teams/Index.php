<?php

/** Goal: Manage team and team members interface, Caller: TeamController / Router, Deps: Team, TeamMember, User */

namespace App\Livewire\Handler\Teams;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    use HandlesErrors;

    public $showMember;

    public ?bool $showModal = false;

    public ?bool $showRemoveMemberModal = false;

    public $team_code = null;

    public $kode_pegawai = null;

    public $newMember = [];

    public $role = null;

    public function showDetail(string $team_code): void
    {
        if ($this->showMember === $team_code) {
            $this->showMember = null;
        } else {
            $this->showMember = $team_code;
        }
    }

    public function addMemberDialog(string $team_code): void
    {
        $this->reset();
        $this->newMember = [];
        $this->showModal = true;
        $this->team_code = $team_code;
        $this->showMember = $team_code;
    }

    public function addMemberProcess(): void
    {
        $this->runSafely(function () {
            DB::transaction(function () {
                foreach ($this->newMember as $member) {
                    TeamMember::create([
                        'team_code' => $this->team_code,
                        'kode_pegawai' => $member,
                        'user_id' => User::where('kode_pegawai', $member)->firstOrFail()->id,
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
    public function removeMemberModal(string|int $kode_pegawai, string $team_code): void
    {
        $this->showRemoveMemberModal = true;
        $this->kode_pegawai = $kode_pegawai;
        $this->team_code = $team_code;
    }

    public function removeMemberProcess(string|int $kode_pegawai, string $team_code): void
    {
        $query = TeamMember::where('kode_pegawai', $kode_pegawai)
            ->where('team_code', $team_code)
            ->first();

        if ($query && $query->role == 'Leader') {
            $this->showRemoveMemberModal = false;
            $this->dispatch('swal', icon: 'error', title: 'Error', text: 'Leader tidak bisa dihapus');

            return;
        }

        $this->runSafely(function () use ($query, $kode_pegawai, $team_code) {
            if ($query) {
                $query->delete();
            }
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

    public function render(): View
    {
        if (Auth::user()->hasPermissionTo('team-list-all')) {
            $teams = Team::with('leader')->get();
        } else {
            $teams = Team::with('leader')->where('team_leader', Auth::user()->kode_pegawai)->get();
        }

        $technicians = User::select(['id', 'name', 'kode_pegawai', 'is_active'])
            ->whereHas('roles', function ($role) {
                $role->where('name', 'Teknisi');
            })
            ->whereDoesntHave('teamMember')
            ->where(function ($query) {
                $query->where('kode_pegawai', 'like', '%'.$this->kode_pegawai.'%')
                    ->orWhere('name', 'like', '%'.$this->kode_pegawai.'%');
            })
            ->where('is_active', true)
            ->limit(5)
            ->get();

        return view('livewire.handler.teams.index', compact('teams', 'technicians'));
    }
}

