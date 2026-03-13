<?php

namespace App\Livewire\Handler\Spk\DailyReport;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Spk\ProjectAssignment;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Reports extends Component
{
    use HandlesErrors, WithPagination;

    public ?string $id;

    public function mount($id)
    {
        $this->id = $id;
    }

    #[Computed]
    public function assignments()
    {
        return ProjectAssignment::with('project')
            ->whereHas('project', function ($project) {
                $project->where('spk_id', $this->id);
            })
            ->latest()
            ->paginate(perPage: 10, pageName: 'assignment-page');
    }

    public function unassign($id)
    {
        $this->runSafely(function () use ($id) {
            // hapus
            ProjectAssignment::where('id', $id)->delete();

            // refresh
            $this->dispatch('$refresh');

            // munculkan pesan
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Staf berhasil dihapus dari projek ini');
        }, 'Staf gagal di hapus dari projek ini.', [
            'user_id' => auth()->id(),
            'action' => 'unassign staf',
        ]);
    }

    public function render()
    {
        return view('livewire.handler.spk.daily-report.reports');
    }
}
