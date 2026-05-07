<?php

namespace App\Livewire\Handler\Spk;

use App\Jobs\ExportPdfJob;
use App\Livewire\Concerns\HandlesErrors;
use App\Models\Spk\ProductionHistory;
use App\Models\Spk\SpkMain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Show extends Component
{
    use HandlesErrors;

    public ?string $id;

    public $data = null;

    public function mount($id)
    {
        $this->data = SpkMain::with('addedBy', 'assignTo', 'updateBy', 'pengirimanUpdatedBy', 'noTagihanUpdatedBy', 'production')
            ->findOrFail($id);
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
                // jika data menunggu validasi dan is_revision true
                if ($this->data->status_approval == 0 && $this->data->is_revision == 1) {
                    $this->data->update([
                        'is_revision' => 0,
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

            $this->dispatch(
                event: 'swal',
                icon: 'success',
                title: 'Berhasil.',
                text: 'Berhasil Approve SPK.');

            return $this->redirect(route('spk.show', $this->data->id), navigate: true);
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
                'nomor_order' => $this->data->nomor_order.'-CANCELLED',
                'status_approval' => 4,
                'is_cancelled' => true,
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

    public function setOldStock()
    {
        // check autorization
        $this->authorize('create', \App\Models\Spk\Production::class);

        // check status spk
        if ($this->data->status_approval != 1) {
            return $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'SPK belum disetujui.');
        }

        // check status booked
        if ($this->data->is_booked) {
            return $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'SPK sudah dibooking.');
        }

        // check status cancelled
        if ($this->data->is_cancelled) {
            return $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'SPK sudah dibatalkan.');
        }

        // proses
        $this->runSafely(function () {
            DB::transaction(function () {
                $this->data->update([
                    'is_using_old_stock' => true,
                    'status' => 2,
                    'purchasing_list_updated_by' => Auth::id(),
                ]);

                // update history gudang
                ProductionHistory::create([
                    'id_produksi' => $this->data->production->id,
                    'judul' => 'SPK telah diset menggunakan stok lama.',
                    'keterangan' => auth()->user()->name.' telah set SPK menggunakan stok lama.',
                    'documentations' => [],
                    'status_produksi' => 1,
                    'status_validasi' => 1,
                ]);
            });

            return $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'SPK telah diset untuk menggunakan stok lama!');
        }, 'Gagal membuat SPK menggunakan stok lama', [
            'user_id' => Auth::id(),
            'spk_id' => $this->data->id,
        ]);
    }

    public function render()
    {
        return view('livewire.handler.spk.show');
    }
}
