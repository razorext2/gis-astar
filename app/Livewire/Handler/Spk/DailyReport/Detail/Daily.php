<?php

namespace App\Livewire\Handler\Spk\DailyReport\Detail;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Spk\ProjectAssignment;
use App\Models\Spk\ProjectDailyReport;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Daily extends Component
{
    use HandlesErrors, WithPagination;

    public ?string $id;

    public $assignment;

    public $route;

    public function mount($id)
    {
        $this->route = request()->route()->getName();

        $this->id = $id;
        $this->assignment = ProjectAssignment::with('project')->findOrFail($id);
    }

    public function add()
    {
        $today = today()->format('Y-m-d');

        // cek dulu apakah sudah ada laporan hari ini
        $data = $this->dailyReports()
            ->where('report_date', $today)
            ->last();

        if ($data) {
            if ($this->route == 'daily-report.daily') {
                $this->redirectRoute('daily-report.hourly', ['id' => $data->assignment_id, 'hourly' => $data->id]);
            } elseif ($this->route == 'report.general.daily') {
                $this->redirectRoute('report.general.hourly', ['id' => $data->assignment_id, 'hourly' => $data->id]);
            } else {
                abort(404);
            }
        } else {
            $this->runSafely(function () {
                // tambah laporan
                ProjectDailyReport::create([
                    'assignment_id' => $this->id,
                    'report_date' => today(),
                    'submitted_at' => now(),
                ]);

                //
                $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Berhasil menambah laporan hari ini.');
            }, 'Gagal menambah laporan hari ini.', [
                'user_id' => auth()->id(),
                'action' => 'add daily report',
            ]);
        }
    }

    #[Computed]
    public function dailyReports()
    {
        return ProjectDailyReport::where('assignment_id', $this->id)
            ->latest()
            ->paginate(10, pageName: 'daily-report-page');
    }

    public function render()
    {
        return view('livewire.handler.spk.daily-report.detail.daily');
    }
}
