<?php

/** Goal: Riwayat Rujukan page — full listing with filters & stats, Caller: riwayat.index */

namespace App\Livewire\Handler\RiwayatRujukan;

use App\Enums\StatusRujukan;
use App\Models\Rujukan;
use App\Models\RumahSakit;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    /** Kata kunci pencarian (nama pasien atau no. rujukan) */
    public string $search = '';

    /** Tanggal mulai filter */
    public string $dateFrom = '';

    /** Tanggal akhir filter */
    public string $dateTo = '';

    /** Filter rumah sakit (kosong = semua) */
    public string $rumahSakitId = '';

    /** Filter status rujukan (kosong = semua) */
    public string $status = '';

    /** Jumlah baris per halaman */
    public int $perPage = 10;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingRumahSakitId(): void
    {
        $this->resetPage();
    }

    public function resetFilter(): void
    {
        $this->search = '';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->rumahSakitId = '';
        $this->status = '';
        $this->resetPage();
    }

    public function applyFilter(): void
    {
        $this->resetPage();
    }

    private function baseQuery()
    {
        $query = Rujukan::query()
            ->with(['pasien', 'rumahSakit', 'detailRujukan'])
            ->orderBy('tanggal_rujukan', 'desc');

        if ($this->search !== '') {
            $keyword = '%'.$this->search.'%';
            $query->where(function ($q) use ($keyword) {
                $q->where('no_rujukan', 'like', $keyword)
                    ->orWhereHas('pasien', fn ($q2) => $q2->where('nama', 'like', $keyword)
                        ->orWhere('no_rm', 'like', $keyword));
            });
        }

        if ($this->dateFrom !== '') {
            $query->whereDate('tanggal_rujukan', '>=', $this->dateFrom);
        }

        if ($this->dateTo !== '') {
            $query->whereDate('tanggal_rujukan', '<=', $this->dateTo);
        }

        if ($this->rumahSakitId !== '') {
            $query->where('id_rumah_sakit', $this->rumahSakitId);
        }

        if ($this->status !== '') {
            $query->where('status', $this->status);
        }

        return $query;
    }

    public function render(): View
    {
        $rujukan = $this->baseQuery()->paginate($this->perPage);

        // Stat counts (all-time, no filters)
        $total = Rujukan::count();
        $selesai = Rujukan::where('status', StatusRujukan::Selesai->value)->count();
        $proses = Rujukan::where('status', StatusRujukan::Disetujui->value)->count();
        $ditolak = Rujukan::where('status', StatusRujukan::Ditolak->value)->count();

        return view('livewire.handler.riwayat-rujukan.index', [
            'rujukanList' => $rujukan,
            'rumahSakitList' => RumahSakit::orderBy('nama_rumah_sakit')->get(['id_rumah_sakit', 'nama_rumah_sakit']),
            'statusOptions' => StatusRujukan::cases(),
            'statsTotal' => $total,
            'statsSelesai' => $selesai,
            'statsProses' => $proses,
            'statsDitolak' => $ditolak,
        ]);
    }
}
