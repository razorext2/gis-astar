<?php

namespace App\Livewire\Handler\BigEventParticipant;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\BigEventParticipant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    use HandlesErrors;

    public bool $showCreateForm = false;

    public ?string $search = '';

    #[Validate('required', message: 'Partisipan harus dipilih')]
    public ?int $user_id = null;

    public ?string $big_event_id;

    #[Validate('required', message: 'Link redirect harus diisi')]
    #[Validate('url', message: 'Link redirect harus valid')]
    public ?string $redirect_to = null;

    public function store()
    {
        $this->validate();

        $user = BigEventParticipant::where('user_id', $this->user_id)
            ->where('big_event_id', $this->big_event_id)
            ->first();

        if ($user) {
            $this->dispatch('swal', icon: 'error', text: 'Partisipan sudah terdaftar', title: 'Gagal');

            $this->resetForm();

            return;
        }

        $this->runSafely(function () {
            DB::transaction(function () {
                $query = BigEventParticipant::create([
                    'big_event_id' => $this->big_event_id,
                    'user_id' => $this->user_id,
                    'visitor_api' => '0',
                    'redirect_to' => $this->redirect_to,
                ]);

                $visitorApi = url("api/event/{$this->big_event_id}/{$query->id}/visitor");

                $query->update([
                    'visitor_api' => $visitorApi,
                ]);
            });

            $this->dispatch('swal', icon: 'success', text: 'Data berhasil disimpan', title: 'Berhasil');
            $this->dispatch('pg:eventRefresh-BigEventParticipantTable');
            $this->resetForm();

        }, 'Gagal menyimpan data.', [
            'user_id' => $this->user_id,
            'big_event_id' => $this->big_event_id,
        ]);
    }

    public function refreshTable()
    {
        $this->dispatch('pg:eventRefresh-BigEventParticipantTable');
    }

    public function resetForm()
    {
        $this->search = null;
        $this->user_id = null;
        $this->redirect_to = null;
        $this->showCreateForm = false;
    }

    public function render()
    {
        if ($this->search) {
            $users = User::where('name', 'like', '%'.$this->search.'%')
                ->limit(5)
                ->get();
        } else {
            $users = User::limit(0)->get();
        }

        return view('livewire.handler.big-event-participant.create', compact('users'));
    }
}
