<?php

namespace App\Livewire\Handler\Spk\DailyReport;

use App\Jobs\ExportPdfJob;
use App\Livewire\Concerns\HandlesErrors;
use App\Mail\SendDailyReportToCustomer;
use App\Models\Spk\ProjectAssignment;
use Illuminate\Support\Facades\Mail;
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

            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Berhasil menyimpan detail customer');

            $this->dispatch('$refresh');
        }, 'Gagal menyimpan detail customer.', [
            'user_id' => auth()->id(),
            'action' => 'store customer info',
        ]);
    }

    public function sentPdfToEmail()
    {
        // cek apakah staf sudah tanda tangan
        if (! $this->model->assignTo->hasBeenSigned()) {
            return $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'Staf belum menandatangani laporan');
        }

        $this->runSafely(function () {
            ExportPdfJob::dispatch(
                auth()->id(),
                'App\Models\Spk\ProjectAssignment',
                $this->id,
                'f4',
                'portrait',
                'dashboard.pdf.preview-laporanharian',
                'Laporan Harian dari kunjungan dengan nomor VT '.$this->model->nomor_vt.' telah siap untuk didownload. Silahkan klik tombol download dibawah ini:',
                'daily-report.pdf.download');

            // kirim email ke customer
            Mail::to($this->model->customer_email)
                ->queue(new SendDailyReportToCustomer(
                    $this->id,
                    $this->model->customer_name,
                    $this->model->project->customer_name,
                    $this->model->assignTo->name));

            // notifikasi
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Berhasil mengirim laporan ke email customer, salinan laporan akan dikirim via notifikasi.');
        }, 'Gagal mengirim laporan ke email customer.', [
            'user_id' => auth()->id(),
            'action' => 'send daily report to customer',
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
