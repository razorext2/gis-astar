<?php

namespace App\Livewire\Handler\Teams;

use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    #[Validate('string|required')]
    public ?string $team_code;

    #[Validate('string|required')]
    public ?string $team_name;

    #[Validate('integer|required')]
    public ?int $team_leader;

    #[Validate('string|required')]
    public ?string $search_user = '';
    public $team;
    public ?bool $removeTeamModal = false;

    public function mount($team_code)
    {
        $this->team = Team::where('team_code', $team_code)->first();
        $this->team_code = $this->team->team_code;
        $this->team_name = $this->team->team_name;
        $this->search_user = $this->team->team_leader;
    }

    public function store()
    {
        // validasi form
        $this->validate();

        try {
            DB::beginTransaction();

            TeamMember::where('team_code', $this->team->team_code)->update([
                'team_code' => $this->team_code,
            ]);

            $this->team->update([
                'team_code' => $this->team_code,
                'team_name' => $this->team_name,
            ]);

            // kalo misal team_leader diubah
            if ($this->team_leader != $this->team->team_leader) {
                // update role leader lama jadi anggota
                TeamMember::where('team_code', $this->team_code)
                    ->where('role', 'Leader')
                    ->update([
                        'role' => 'anggota',
                    ]);

                // update anggota jadi leader baru
                TeamMember::where('team_code', $this->team_code)
                    ->where('kode_pegawai', $this->team_leader)
                    ->update([
                        'role' => 'Leader'
                    ]);

                // update leader di team nya juga
                Team::where('team_code', $this->team_code)->update([
                    'team_leader' => $this->team_leader,
                ]);
            }

            DB::commit();
            session()->flash('status', 'Tim berhasil diupdate.');
            return $this->redirect(route('teams.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
            return $this->redirect(route('teams.index'));
        }
    }

    public function removeTeamProcess()
    {
        try {
            DB::beginTransaction();

            // hapus member pada team
            TeamMember::where('team_code', $this->team->team_code)->delete();

            // hapus team
            $this->team->delete();

            DB::commit();
            session()->flash('status', 'Tim berhasil dihapus.');
            return $this->redirect(route('teams.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->dispatch('swal', icon: 'error', title: 'Gagal', text: $e->getMessage());
        }
    }

    public function render()
    {
        $users = User::where('kode_pegawai', 'like', '%' . $this->search_user . '%')
            ->orWhere('name', 'like', '%' . $this->search_user . '%')
            ->limit(5)
            ->get();

        return view('livewire.handler.teams.edit', compact('users'));
    }
}
