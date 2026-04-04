<?php

namespace App\Livewire\Handler\Spk\DailyReport\Detail;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Spk\ProjectAssignment;
use App\Models\Spk\ProjectDailyReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Daily extends Component
{
    use HandlesErrors, WithPagination;

    public ?string $id;

    public bool $showSummaryModal = false;

    public bool $showExtendModal = false;

    public bool $showAcceptButton = true;

    public bool $showDenyButton = true;

    public bool $showDenyProcessButton = false;

    public bool $showCancelButton = false;

    public $assignment;

    public $route;

    public $modalData;

    public ?int $days = 1;

    public ?string $extend_reason = '';

    public ?string $extend_request_rejected_notes = '';

    public function rules()
    {
        return [
            'days' => 'required|numeric|min:1|max:20',
            'extend_reason' => 'required|string|min:5|max:255',
        ];
    }

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
                DB::transaction(function () {
                    // tambah laporan
                    ProjectDailyReport::create([
                        'assignment_id' => $this->id,
                        'report_date' => today(),
                        'submitted_at' => now(),
                    ]);

                    // update status
                    $this->assignment->update([
                        'status' => 'in_progress',
                    ]);
                });

                // swal
                $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Berhasil menambah laporan hari ini.');

                // refresh
                $this->dispatch('$refresh');
            }, 'Gagal menambah laporan hari ini.', [
                'user_id' => auth()->id(),
                'action' => 'add daily report',
            ]);
        }
    }

    public function summary(string $id)
    {
        $this->modalData = ProjectDailyReport::where('id', $id)->first();

        $this->showSummaryModal = true;
    }

    public function approve()
    {
        $this->runSafely(function () {
            $this->modalData->update([
                'status' => 'approved',
            ]);

            // show swal
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Berhasil menyetujui laporan harian.');

            // reset modal
            $this->showSummaryModal = false;

            // reset modal data
            $this->modalData = null;

            // refresh
            $this->dispatch('$refresh');
        }, 'Gagal menyetujui laporan harian.', [
            'user_id' => auth()->id(),
            'action' => 'approve daily report',
        ]);
    }

    public function extendProcess()
    {
        $this->validate();

        $this->runSafely(function () {
            $project = $this->assignment->project;

            $query = $project->update([
                'extend_request' => true,
                'extend_to' => $project->end_date->addDays($this->days),
                'extend_request_by' => auth()->id(),
                'extend_request_at' => now(),
                'extend_request_notes' => $this->extend_reason,
                'extend_request_status' => 'pending',
            ]);

            if (! $query) {
                throw new \Exception('Gagal meminta perpanjangan');
            }

            // show swal
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Berhasil meminta perpanjangan.');

            // reset modal
            $this->showExtendModal = false;

            // refresh
            $this->dispatch('$refresh');
        }, 'Gagal meminta perpanjangan', [
            'user_id' => auth()->id(),
            'action' => 'request extend',
        ]);
    }

    public function acceptExtendRequest()
    {
        if (auth()->user()->cannot('laporan-harian-validate')) {
            abort(403);
        }

        $this->runSafely(function () {
            // update
            $query = $this->assignment->project->update([
                'extend_request_status' => 'approved',
                'extend_request_validated_at' => now(),
                'extend_request_validated_by' => auth()->id(),
                'end_date' => $this->assignment->project->extend_to,
                'deadline' => $this->assignment->project->extend_to,
            ]);

            if (! $query) {
                throw new \Exception('Gagal menyetujui perpanjangan');
            }

            // show swal
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Berhasil menyetujui perpanjangan.');

            // refresh
            $this->dispatch('$refresh');
        }, 'Gagal menyetujui perpanjangan.', [
            'user_id' => auth()->id(),
            'action' => 'accept extend request',
        ]);
    }

    public function rejectExtendRequestProcess()
    {
        if (auth()->user()->cannot('laporan-harian-validate')) {
            abort(403);
        }

        $this->runSafely(function () {
            // update
            $query = $this->assignment->project->update([
                'extend_request_status' => 'rejected',
                'extend_request_validated_at' => now(),
                'extend_request_validated_by' => auth()->id(),
                'extend_request_validated_notes' => $this->extend_request_rejected_notes,
            ]);

            if (! $query) {
                throw new \Exception('Gagal menyetujui perpanjangan');
            }

            // show swal
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Berhasil menolak perpanjangan.');

            // refresh
            $this->dispatch('$refresh');
        }, 'Gagal menolak perpanjangan.', [
            'user_id' => auth()->id(),
            'action' => 'accept extend request',
        ]);
    }

    public function markAsComplete()
    {
        // cek otoritas
        if (auth()->user()->cannot('laporan-harian-validate')) {
            return abort(403);
        }

        $this->runSafely(function () {
            //    update status
            $this->assignment->update([
                'status' => 'completed',
            ]);
        }, 'Gagal menandai laporan harian sebagai selesai.', [
            'user_id' => auth()->id(),
            'action' => 'daily report mark as complete',
        ]);
    }

    public function getSisaHari()
    {
        $start = Carbon::parse($this->assignment->project->start_date);
        $end = Carbon::parse($this->assignment->project->end_date)->endOfDay();
        $now = Carbon::now();

        $total = $start->diffInDays($end);
        $sisaHari = (int) $now->diffInDays($end, false);
        $sisaJam = (int) $now->diffInHours($end, false);

        if ($sisaHari < 0) {
            return ['type' => 'danger', 'label' => 'Deadline'];
        }

        if ($sisaJam < 24) {
            return ['type' => 'danger', 'label' => 'Hari ini!'];
        }

        if ($sisaHari <= ($total / 2)) {
            return ['type' => 'warning', 'label' => "{$sisaHari} Hari lagi!"];
        }

        return ['type' => 'success', 'label' => "{$sisaHari} Hari"];
    }

    public function rejectExtendRequest()
    {
        $this->showAcceptButton = false;
        $this->showDenyButton = false;
        $this->showDenyProcessButton = true;
        $this->showCancelButton = true;
    }

    public function handleCancelButton()
    {
        $this->showCancelButton = false;
        $this->showDenyProcessButton = false;
        $this->showAcceptButton = true;
        $this->showDenyButton = true;
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
