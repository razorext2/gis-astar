<?php

/** Goal: Tampilkan detail laporan teknisi & handle aksi konfirmasi/tolak/revisi, Caller: dashboard/technician/detail.blade.php, Deps: Technician, PhotoCollect, Http, HandlesErrors */

namespace App\Livewire\Handler\Technician;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Technician;
use App\Models\TechnicianPoints;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Show extends Component
{
    use HandlesErrors;

    /** ID integer (plain) dari record Technician. Dikunci agar tidak bisa dimanipulasi dari frontend. */
    #[Locked]
    public int $id;

    /** Data laporan teknisi yang sedang ditampilkan. */
    public Technician $report;

    /** Apakah modal alasan sedang terbuka. */
    public bool $showReasonModal = false;

    /** Tipe aksi yang sedang diproses: 'deny' | 'revision'. */
    public string $actionType = '';

    /** Alasan tolak atau revisi. */
    #[Validate('required|string|min:5|max:200')]
    public string $reason = '';

    public function mount(): void
    {
        $this->report = Technician::query()
            ->with([
                'pegawai:kode_pegawai,full_name,no_telp',
                'photo_collects:id,no_vt,photourl',
                'user:id,name',
                'revised_by:id,name',
            ])
            ->findOrFail($this->id);
    }

    /**
     * Konfirmasi laporan — set status ke 1 (Diterima) & update ke server eksternal.
     * Hanya bisa dilakukan oleh user dengan permission 'technician-approve'.
     */
    public function confirm(): void
    {
        $this->authorize('technician-approve');

        $this->runSafely(function () {
            DB::transaction(function () {
                $this->report->refresh();

                abort_if($this->report->status !== 0, 403, 'Laporan ini sudah diproses sebelumnya.');

                $point = TechnicianPoints::where('from_vt', $this->report->no_vt)->first();

                $this->report->update([
                    'status' => 1,
                    'validate_by' => Auth::id(),
                    'validate_at' => now(),
                ]);

                if ($point) {
                    $point->update(['is_redeemable' => 1]);
                }

                // Sinkronisasi ke server eksternal
                if (app()->isProduction()) {
                    Http::asForm()->post('https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=updateKunjungan', [
                        'NomorKunjungan' => $this->report->no_vt,
                        'UpdatePekerjaan' => $this->report->job_update,
                        'JenisTimbangan' => $this->report->weight_type,
                        'Ukuran' => $this->report->size,
                        'Kapasitas' => $this->report->capacity,
                        'TipeIndikator' => $this->report->indicator_type,
                        'TipeIndikatorSN' => $this->report->indicator_sn,
                        'TipeLoadcell' => $this->report->loadcell_type,
                        'TipeLoadcellSN' => $this->report->loadcell_sn,
                        'TipeJunctionBox' => $this->report->junction_type,
                        'TipeJunctionBoxSN' => $this->report->loadcell_qty,
                    ]);
                }
            });

            $this->report->refresh();

            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Laporan kunjungan telah dikonfirmasi.');
        }, 'Gagal mengkonfirmasi laporan teknisi.', [
            'action' => 'confirm technician report',
            'technician_id' => $this->id,
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * Buka modal untuk input alasan tolak / revisi.
     */
    public function openReasonModal(string $type): void
    {
        $this->authorize('technician-approve');

        abort_unless(in_array($type, ['deny', 'revision']), 400);

        $this->actionType = $type;
        $this->reason = '';
        $this->resetValidation();
        $this->showReasonModal = true;
    }

    /**
     * Submit alasan dan jalankan aksi (deny atau revision).
     */
    public function submitReason(): void
    {
        $this->authorize('technician-approve');
        $this->validate();

        match ($this->actionType) {
            'deny' => $this->processDeny(),
            'revision' => $this->processRevision(),
            default => abort(400),
        };
    }

    private function processDeny(): void
    {
        $this->runSafely(function () {
            $this->report->refresh();
            abort_if($this->report->status !== 0, 403, 'Laporan ini sudah diproses sebelumnya.');

            $this->report->update([
                'status' => 3,
                'validate_by' => Auth::id(),
                'validate_at' => now(),
                'notes' => $this->reason,
            ]);

            $this->report->refresh();
            $this->showReasonModal = false;

            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Laporan kunjungan telah ditolak.');
        }, 'Gagal menolak laporan teknisi.', [
            'action' => 'deny technician report',
            'technician_id' => $this->id,
            'user_id' => Auth::id(),
        ]);
    }

    private function processRevision(): void
    {
        $this->runSafely(function () {
            $this->report->refresh();
            abort_if($this->report->status !== 0, 403, 'Laporan ini sudah diproses sebelumnya.');

            $this->report->update([
                'status' => 2,
                'validate_by' => Auth::id(),
                'validate_at' => now(),
                'notes' => $this->reason,
                'total_revision' => $this->report->total_revision + 1,
            ]);

            $this->report->refresh();
            $this->showReasonModal = false;

            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Permintaan revisi telah dikirim.');
        }, 'Gagal mengirim revisi laporan teknisi.', [
            'action' => 'revision technician report',
            'technician_id' => $this->id,
            'user_id' => Auth::id(),
        ]);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.handler.technician.show');
    }
}
