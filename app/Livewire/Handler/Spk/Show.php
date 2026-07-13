<?php

namespace App\Livewire\Handler\Spk;

use App\Jobs\ExportPdfJob;
use App\Livewire\Concerns\HandlesErrors;
use App\Models\Spk\ProductionHistory;
use App\Models\Spk\SpkMain;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Show extends Component
{
    use HandlesErrors;

    public ?string $id;

    public $data = null;

    public bool $showReassignModal = false;

    public ?int $selectedReassignUserId = null;

    public bool $showOldStockModal = false;

    public string $oldStockNotes = '';

    public function mount($id): void
    {
        $this->data = SpkMain::with([
            'addedBy',
            'assignTo',
            'reassignTo',
            'updateBy',
            'pengirimanUpdatedBy',
            'noTagihanUpdatedBy',
            'production',
            'bookedBy',
            'approvedBy',
            'cancelRequestBy',
            'cancelRequestValidatedBy',
        ])->findOrFail($id);
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

    public function openOldStockModal()
    {
        $this->authorize('create', \App\Models\Spk\Production::class);

        if ($this->data->tipe_timbangan !== 'timbangan jembatan') {
            return $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'Fitur stok lama hanya berlaku untuk SPK timbangan jembatan.');
        }

        if ($this->data->status_approval != 1) {
            return $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'SPK belum disetujui.');
        }

        if ($this->data->is_booked) {
            return $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'SPK sudah dibooking.');
        }

        if ($this->data->is_cancelled) {
            return $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'SPK sudah dibatalkan.');
        }

        $this->oldStockNotes = '';
        $this->showOldStockModal = true;
    }

    public function setOldStock()
    {
        // check autorization
        $this->authorize('create', \App\Models\Spk\Production::class);

        if ($this->data->tipe_timbangan !== 'timbangan jembatan') {
            return $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'Fitur stok lama hanya berlaku untuk SPK timbangan jembatan.');
        }

        if ($this->data->status_approval != 1) {
            return $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'SPK belum disetujui.');
        }

        if ($this->data->is_booked) {
            return $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'SPK sudah dibooking.');
        }

        if ($this->data->is_cancelled) {
            return $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'SPK sudah dibatalkan.');
        }

        // proses
        $this->runSafely(function () {
            DB::transaction(function () {
                $this->data->update([
                    'is_using_old_stock' => true,
                    'old_stock_notes' => $this->oldStockNotes ?: null,
                    'status' => 2,
                    'purchasing_list_updated_by' => Auth::id(),
                ]);

                // update history gudang
                ProductionHistory::create([
                    'id_produksi' => $this->data->production->id,
                    'judul' => 'SPK telah diset menggunakan stok lama.',
                    'keterangan' => Auth::user()->name.' telah set SPK menggunakan stok lama. Catatan: ' . ($this->oldStockNotes ?: '-'),
                    'documentations' => [],
                    'status_produksi' => 1,
                    'status_validasi' => 1,
                ]);

                $this->data->addHistory(
                    'SPK menggunakan stok lama.',
                    Auth::user()->name.' telah menandai SPK ini menggunakan stok lama. Catatan: ' . ($this->oldStockNotes ?: '-'),
                    Auth::id()
                );
            });

            $this->showOldStockModal = false;
            $this->oldStockNotes = '';

            return $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'SPK telah diset untuk menggunakan stok lama!');
        }, 'Gagal membuat SPK menggunakan stok lama', [
            'user_id' => Auth::id(),
            'spk_id' => $this->data->id,
        ]);
    }

    public bool $isReturnToIdc = false;

    /** Goal: Buka modal reassign dan reset state pencarian. */
    public function openReassignModal(): void
    {
        $this->selectedReassignUserId = null;
        $this->isReturnToIdc = false;
        $this->showReassignModal = true;
    }

    /** Goal: Computed property untuk list pegawai produksi yang aktif. */
    #[Computed]
    public function produksiUsers(): \Illuminate\Support\Collection
    {
        return User::whereHas('roles', fn ($role) => $role->where('name', 'Produksi'))
            ->where('is_active', true)
            ->where('id', '!=', $this->data->assign_to)
            ->get();
    }

    /** Goal: Proses reassign SPK ke pegawai terpilih, update DB, catat history. */
    public function processReassign(): void
    {
        $this->authorize('spk-reassign');

        if ($this->isReturnToIdc) {
            $this->runSafely(function () {
                DB::transaction(function () {
                    $reassignData = [
                        'reassign_to' => null,
                        'reassign_by' => null,
                        'reassign_at' => null,
                    ];

                    $this->data->update($reassignData);
                    $this->data->production()->update($reassignData);

                    $this->data->spkHistories()->create([
                        'title' => 'SPK dikembalikan ke IDC.',
                        'keterangan' => Auth::user()->name.' telah mengembalikan SPK ke staf yang di-assign sebelumnya.',
                        'added_by' => Auth::id(),
                    ]);
                });

                $this->showReassignModal = false;

                $this->dispatch(
                    event: 'swal',
                    icon: 'success',
                    title: 'Berhasil.',
                    text: 'SPK berhasil dikembalikan ke staf assign sebelumnya.');

                return $this->redirect(route('spk.show', $this->data->id), navigate: true);
            }, 'Gagal mengembalikan SPK.', [
                'user_id' => Auth::id(),
                'spk_id' => $this->data->id,
            ]);

            return;
        }

        if (! $this->selectedReassignUserId) {
            $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'Pilih pegawai terlebih dahulu.');

            return;
        }

        $targetUser = User::find($this->selectedReassignUserId, 'id');

        if (! $targetUser) {
            $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'Pegawai tidak ditemukan.');

            return;
        }

        $this->runSafely(function () use ($targetUser) {
            DB::transaction(function () use ($targetUser) {
                $reassignData = [
                    'reassign_to' => $targetUser->id,
                    'reassign_by' => Auth::id(),
                    'reassign_at' => now(),
                ];

                $this->data->update($reassignData);
                $this->data->production()->update($reassignData);

                $this->data->spkHistories()->create([
                    'title' => 'SPK di-reassign.',
                    'keterangan' => Auth::user()->name.' telah mereassign SPK kepada '.$targetUser->name.' ('.$targetUser->kode_pegawai.').',
                    'added_by' => Auth::id(),
                ]);
            });

            $this->showReassignModal = false;

            $this->dispatch(
                event: 'swal',
                icon: 'success',
                title: 'Berhasil.',
                text: 'SPK berhasil di-reassign kepada '.$targetUser->name.'.');

            return $this->redirect(route('spk.show', $this->data->id), navigate: true);
        }, 'Gagal mereassign SPK.', [
            'user_id' => Auth::id(),
            'spk_id' => $this->data->id,
            'target_user_id' => $targetUser->id,
        ]);
    }

    public function render()
    {
        return view('livewire.handler.spk.show');
    }
}
