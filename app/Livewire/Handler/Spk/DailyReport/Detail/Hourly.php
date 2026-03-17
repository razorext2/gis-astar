<?php

namespace App\Livewire\Handler\Spk\DailyReport\Detail;

use App\Livewire\Concerns\HandlesErrors;
use App\Livewire\Forms\DailyReport\Hourly as HourlyForm;
use App\Livewire\Forms\Spk\Attachment;
use App\Models\Spk\ProjectDailyReport;
use App\Models\Spk\ProjectHourlyReport;
use App\Models\Spk\ProjectHourlyReportFile;
use App\Services\HourlyReportServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class Hourly extends Component
{
    use HandlesErrors, WithFileUploads, WithPagination;

    public HourlyForm $form;

    public Attachment $docForm;

    public $id;

    public $dailyReport;

    public $route;

    public ?bool $showAddForm = true;

    public function mount($id)
    {
        // assign route saat ini
        $this->route = request()->route()->getName();

        // assign id daily report
        $this->id = $id;

        // assign report
        $this->dailyReport = ProjectDailyReport::with('hourlyReport', 'assignment')
            ->findOrFail($id);
    }

    public function storeLampiran()
    {
        $this->docForm->attachment_type = 'report-attachment';

        $this->docForm->addAttachment();
    }

    public function removeAttachment($index)
    {
        $this->docForm->removeAttachment($index);
    }

    public function reportSubmit()
    {
        $model = $this->dailyReport;

        if (count($model->hourlyReport) === 0) {
            return $this->dispatch('swal', icon: 'warning', title: 'Perhatian', text: 'Anda belum menambahkan aktivitas laporan harian!');
        }

        $this->runSafely(function () use ($model) {
            // update status
            $model->update([
                'status' => 'submitted',
            ]);

            // tampilkan swal
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Laporan harian berhasil diajukan');

            // refresh
            $this->dispatch('$refresh');
        }, 'Gagal mengajukan laporan', [
            'user_id' => auth()->id(),
            'action' => 'submit report',
        ]);
    }

    public function store()
    {
        $this->form->validate();

        $this->runSafely(function () {
            // inisialisasi service
            $activities = ProjectHourlyReport::where('daily_report_id', $this->id)->get();
            $service = new HourlyReportServices;

            // cek apakah ada overlap
            $service->compareTime($this->form->start_time, $this->form->end_time);
            $service->validateNoOverlap($this->form->start_time, $this->form->end_time, $activities);

            DB::transaction(function () {
                // tambah detail aktivitas
                $project = ProjectHourlyReport::create([
                    'daily_report_id' => $this->id,
                    'start_time' => $this->form->start_time,
                    'end_time' => $this->form->end_time,
                    'activity' => $this->form->activity,
                    'location' => null,
                    'notes' => $this->form->notes,
                ]);

                // simpan lampiran ke variabel
                $attachments = $this->docForm->storeAttachment();

                // map data lampiran
                $data = array_map(function ($attachment) use ($project) {
                    return [
                        'id' => Str::ulid(),
                        'hourly_report_id' => $project->id,
                        'file_path' => $attachment['url'],
                        'file_type' => $attachment['tipe_dokumen'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }, $attachments);

                // bulk insert
                ProjectHourlyReportFile::insert($data);
            });

            // reset form
            $this->form->reset();
            $this->docForm->reset();

            // refresh
            $this->dispatch('$refresh');

            // tampilkan swal
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Detail aktivitas berhasil ditambahkan');
        }, 'Gagal menambah detail aktivitas laporan harian', [
            'user_id' => auth()->id(),
            'action' => 'add hourly report',
        ]);
    }

    public function delete($id)
    {
        $this->runSafely(function () use ($id) {
            // hapus detail aktivitas
            ProjectHourlyReport::findOrFail($id)->delete();

            // refresh
            $this->dispatch('$refresh');

            // tampilkan swal
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Detail aktivitas berhasil dihapus');
        }, 'Gagal menghapus aktivitas laporan harian', [
            'user_id' => auth()->id(),
            'action' => 'delete hourly report',
        ]);
    }

    #[Computed]
    public function hourlyReports()
    {
        return $this->dailyReport
            ->hourlyReport()
            ->with('files')
            ->orderBy('start_time', 'desc')
            ->paginate(10, pageName: 'hourly-report-page');
    }

    public function render()
    {
        return view('livewire.handler.spk.daily-report.detail.hourly');
    }
}
