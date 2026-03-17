<?php

namespace App\Livewire\Handler\Spk\DailyReport;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Spk\ProjectAssignment;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Signature extends Component
{
    use HandlesErrors;

    public $id;

    public ?string $name = '';

    public ?string $email = '';

    public ProjectAssignment $model;

    public function rule()
    {
        return [
            'name' => 'required|string|min:5',
            'email' => 'required|email|min:3',
        ];
    }

    public function mount($id)
    {
        $this->id = $id;
        $this->model = ProjectAssignment::find($id);

        $this->name = $this->model->customer_name ?? '';
        $this->email = $this->model->customer_email ?? '';
    }

    public function store()
    {
        $this->runSafely(function () {
            // update detail
            $this->model->update([
                'customer_name' => $this->name,
                'customer_email' => $this->email,
            ]);

            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Berhasil menyimpan detail packinglist');

            $this->dispatch('$refresh');
        }, 'Gagal menyimpan detail packinglist.', [
            'user_id' => auth()->id(),
            'action' => 'store customer info',
        ]);
    }

    #[Computed]
    public function assigments()
    {
        return ProjectAssignment::where('id', $this->id)
            ->with(['dailyReports.hourlyReport'])
            ->get();
    }

    public function render()
    {
        return view('livewire.handler.spk.daily-report.signature');
    }
}
