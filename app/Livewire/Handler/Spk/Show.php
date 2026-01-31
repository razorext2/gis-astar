<?php

namespace App\Livewire\Handler\Spk;

use App\Jobs\ExportPdfJob;
use App\Livewire\Concerns\HandlesErrors;
use App\Models\Spk\SpkMain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use HandlesErrors, WithPagination;

    public ?string $id;

    public ?bool $showRiwayatSpk = false;

    public $data = null;

    public function construct($id)
    {
        // assign id
        $this->id = $id;
    }

    public function mount()
    {
        $this->data = SpkMain::with('addedBy', 'assignTo', 'updateBy', 'pengirimanUpdatedBy', 'noTagihanUpdatedBy', 'spkHistories')
            ->findOrFail($this->id);
    }

    public function validateSpk()
    {
        $this->authorize('validate', SpkMain::class);

        if ($this->data->is_booked) {
            return $this->dispatch(event: 'swal', icon: 'error', title: 'Gagal', text: 'SPK masih dalam status booking, tidak bisa diapprove.');
        }

        if ($this->data->on_delay) {
            return $this->dispatch(event: 'swal', icon: 'error', title: 'Gagal', text: 'SPK sedang dalam status on delay, tidak bisa diapprove.');
        }

        $this->runSafely(function () {
            DB::transaction(function () {
                if ($this->data->status_approval == 0 && $this->data->is_revision == true) {
                    $this->data->update([
                        'is_revision' => false,
                        'revision_count' => $this->data->revision_count + 1,
                    ]);
                }

                $this->data->update([
                    'status_approval' => 1,
                    'approved_by' => Auth::id(),
                    'approved_at' => now(),
                ]);

                $this->data->spkHistories()->create([
                    'title' => 'SPK telah disetujui.',
                    'keterangan' => Auth::user()->name.' telah menyetujui SPK. Sekarang SPK dapat lanjut ke tahap selanjutnya.',
                    'added_by' => Auth::id(),
                ]);
            });

            return $this->dispatch(
                event: 'swal',
                icon: 'success',
                title: 'Berhasil.',
                text: 'Berhasil Approve SPK.');
        }, 'Gagal menyetujui SPK.', [
            'user_id' => Auth::id(),
            'spk_id' => $this->data->id,
            'spk_nomor_order' => $this->data->nomor_order,
        ]);
    }

    public function cancelSpk()
    {
        $this->authorize('validate', SpkMain::class);

        $this->runSafely(function () {
            $this->data->update([
                'status_approval' => 4,
                'cancel_request_validated_by' => Auth::id(),
                'cancel_request_validated_at' => now(),
            ]);

            $this->dispatch(
                event: 'swal',
                title: 'Berhasil.',
                icon: 'success',
                text: 'Berhasil membatalkan SPK.');
        }, 'Gagal membatalkan SPK', [
            'user_id' => Auth::id(),
            'spk_id' => $this->data->id,
            'spk_nomor_order' => $this->data->nomor_order,
        ]);
    }

    public function export()
    {
        $this->runSafely(function () {
            ExportPdfJob::dispatch(
                Auth::id(),
                'App\Models\Spk\SpkMain',
                $this->id,
                'f4',
                'portrait',
                'dashboard.pdf.spksummary',
                'SPK '.$this->data->nomor_order.' anda telah siap untuk didownload. Silahkan klik tombol download dibawah ini:',
                'spk.download');

            $this->dispatch(event: 'swal', icon: 'success', title: 'Berhasil', text: 'Berhasil melakukan ekspor, silahkan menunggu notifikasi ekspor telah selesai.');
        }, 'Gagal melakukan ekspor', [
            'user_id' => Auth::id(),
            'action' => 'export',
            'data' => $this->id,
        ]);
    }

    public function getFilteredAttachmentsExcludeRequestFondasiProperty()
    {
        return collect($this->data->documentations)
            ->where('tipe_dokumen', '!=', 'request_fondasi')
            ->values();
    }

    public function getFilteredAttachmentsOnlyRequestFondasiProperty()
    {
        return collect($this->data->documentations)
            ->where('tipe_dokumen', '=', 'request_fondasi')
            ->values();
    }

    public function render()
    {
        return view('livewire.handler.spk.show', [
            'spkHistories' => $this->data->spkHistories()->latest()->paginate(5, pageName: 'spk-page'),
        ]);
    }
}
