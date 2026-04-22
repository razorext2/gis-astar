<?php

namespace App\Livewire\Handler\Teams;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    use HandlesErrors;

    #[Validate('string|required|unique:tb_teams,team_code', message: 'Kode Tim sudah ada!')]
    public ?string $team_code;

    #[Validate('string|required|unique:tb_teams,team_name', message: 'Nama Tim sudah ada!')]
    public ?string $team_name;

    #[Validate('integer|required|unique:tb_teams,team_leader', message: 'Kode Jari Ketua Tim sudah ada!')]
    public ?int $team_leader;

    #[Validate('string|required', message: 'Kode Jari Ketua Tim harus 2-8 karakter!')]
    public ?string $search_user = '';

    public function store()
    {
        // validasi form
        $this->validate();

        // cek nama team dari API
        $checkTeamName = Http::get("https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchteam&namateam=$this->team_name");

        $result = $checkTeamName->json();

        if ($result['status'] == 'error') {
            return $this->dispatch('swal', icon: 'error', title: 'Nama tim tidak ditemukan', text: 'Silahkan buat team baru terlebih dahulu di aplikasi BSI');
        }

        $this->runSafely(function () {
            DB::transaction(function () {
                // buat tim
                Team::create([
                    'team_code' => $this->team_code,
                    'team_name' => $this->team_name,
                    'team_position' => 'Teknisi',
                    'team_leader' => $this->team_leader,
                ]);

                // tambah leader ke team
                TeamMember::create([
                    'team_code' => $this->team_code,
                    'kode_pegawai' => $this->team_leader,
                    'user_id' => User::where('kode_pegawai', $this->team_leader)->firstOrFail()->id,
                    'role' => 'Leader',
                ]);

                // assign role
                User::where('kode_pegawai', $this->team_leader)
                    ->firstOrFail()
                    ->assignRole('Kepala-Teknisi');
            });

            $this->reset();
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Tim berhasil ditambahkan!');
        }, 'Gagal menambahkan tim baru.', [
            'action' => 'create team',
            'team_code' => $this->team_code,
            'user_id' => auth()->id(),
        ]);
    }

    public function render()
    {
        $users = User::where('kode_pegawai', 'like', '%'.$this->search_user.'%')
            ->orWhere('name', 'like', '%'.$this->search_user.'%')
            ->limit(5)
            ->get();

        return view('livewire.handler.teams.create', compact('users'));
    }
}
