<?php

/** Goal: Update status rujukan (setuju/tolak/selesai), Caller: rujukan.update-status */

namespace App\Livewire\Handler\Rujukan;

use App\Enums\StatusRujukan;
use App\Livewire\Concerns\HandlesErrors;
use App\Models\Rujukan;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class UpdateStatus extends Component
{
    use HandlesErrors;

    public Rujukan $rujukan;

    public string $status = '';

    public ?string $keterangan = null;

    public function mount(Rujukan $rujukan): void
    {
        $this->rujukan = $rujukan->load(['pasien', 'rumahSakit']);
        $this->status = $rujukan->status->value;
        $this->keterangan = $rujukan->keterangan;
    }

    protected function rules(): array
    {
        return [
            'status' => 'required|in:pending,disetujui,ditolak,selesai',
            'keterangan' => 'nullable|string|max:1000',
        ];
    }

    public function save(): void
    {
        $this->validate();

        $this->runSafely(function () {
            $this->rujukan->update([
                'status' => $this->status,
                'keterangan' => $this->keterangan,
            ]);

            $statusLabel = StatusRujukan::from($this->status)->label();
            $this->dispatch('swal', title: 'Berhasil', text: "Status rujukan diubah menjadi: {$statusLabel}", icon: 'success');
            $this->redirect(route('rujukan.show', $this->rujukan->id_rujukan), navigate: true);
        }, 'Gagal mengubah status rujukan', ['rujukan_id' => $this->rujukan->id_rujukan]);
    }

    /** Opsi status yang tersedia (semua kecuali status saat ini) */
    public function getStatusOptionsProperty(): array
    {
        return collect(StatusRujukan::cases())
            ->map(fn ($s) => ['value' => $s->value, 'label' => $s->label()])
            ->all();
    }

    public function render(): View
    {
        return view('livewire.handler.rujukan.update-status');
    }
}
