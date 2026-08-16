<?php

/** Goal: Laporan Pasien & Riwayat Rujukan dengan Multi-Tab, Filter, Metrik KPI, Ekspor CSV, dan Cetak */

namespace App\Livewire\Handler\Laporan;

use App\Enums\JenisKelamin;
use App\Enums\StatusRujukan;
use App\Livewire\Concerns\HandlesErrors;
use App\Models\Pasien;
use App\Models\Rujukan;
use App\Models\RumahSakit;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Index extends Component
{
    use HandlesErrors, WithPagination;

    /** Tab aktif: 'rujukan' atau 'pasien' */
    public string $activeTab = 'rujukan';

    /** Filter Laporan Rujukan */
    public string $rujukanSearch = '';

    public string $rujukanDateFrom = '';

    public string $rujukanDateTo = '';

    public string $rujukanStatus = '';

    public string $rujukanRsId = '';

    public int $rujukanPerPage = 10;

    /** Filter Laporan Pasien */
    public string $pasienSearch = '';

    public string $pasienDateFrom = '';

    public string $pasienDateTo = '';

    public string $pasienGender = '';

    public string $pasienCoordStatus = '';

    public int $pasienPerPage = 10;

    public function setTab(string $tab): void
    {
        if (in_array($tab, ['rujukan', 'pasien'], true)) {
            $this->activeTab = $tab;
        }
    }

    public function updatingRujukanSearch(): void
    {
        $this->resetPage('rujukanPage');
    }

    public function updatingRujukanStatus(): void
    {
        $this->resetPage('rujukanPage');
    }

    public function updatingRujukanRsId(): void
    {
        $this->resetPage('rujukanPage');
    }

    public function updatingRujukanDateFrom(): void
    {
        $this->resetPage('rujukanPage');
    }

    public function updatingRujukanDateTo(): void
    {
        $this->resetPage('rujukanPage');
    }

    public function updatingRujukanPerPage(): void
    {
        $this->resetPage('rujukanPage');
    }

    public function updatingPasienSearch(): void
    {
        $this->resetPage('pasienPage');
    }

    public function updatingPasienGender(): void
    {
        $this->resetPage('pasienPage');
    }

    public function updatingPasienCoordStatus(): void
    {
        $this->resetPage('pasienPage');
    }

    public function updatingPasienDateFrom(): void
    {
        $this->resetPage('pasienPage');
    }

    public function updatingPasienDateTo(): void
    {
        $this->resetPage('pasienPage');
    }

    public function updatingPasienPerPage(): void
    {
        $this->resetPage('pasienPage');
    }

    public function resetRujukanFilter(): void
    {
        $this->rujukanSearch = '';
        $this->rujukanDateFrom = '';
        $this->rujukanDateTo = '';
        $this->rujukanStatus = '';
        $this->rujukanRsId = '';
        $this->resetPage('rujukanPage');
    }

    public function resetPasienFilter(): void
    {
        $this->pasienSearch = '';
        $this->pasienDateFrom = '';
        $this->pasienDateTo = '';
        $this->pasienGender = '';
        $this->pasienCoordStatus = '';
        $this->resetPage('pasienPage');
    }

    public function getRujukanQuery(): Builder
    {
        $query = Rujukan::query()
            ->with(['pasien', 'rumahSakit', 'user', 'detailRujukan'])
            ->orderBy('tanggal_rujukan', 'desc');

        if ($this->rujukanSearch !== '') {
            $keyword = '%'.$this->rujukanSearch.'%';
            $query->where(function (Builder $q) use ($keyword) {
                $q->where('no_rujukan', 'like', $keyword)
                    ->orWhereHas('pasien', fn (Builder $q2) => $q2->where('nama', 'like', $keyword)
                        ->orWhere('nik', 'like', $keyword)
                        ->orWhere('no_rm', 'like', $keyword))
                    ->orWhereHas('rumahSakit', fn (Builder $q2) => $q2->where('nama_rumah_sakit', 'like', $keyword));
            });
        }

        if ($this->rujukanDateFrom !== '') {
            $query->whereDate('tanggal_rujukan', '>=', $this->rujukanDateFrom);
        }

        if ($this->rujukanDateTo !== '') {
            $query->whereDate('tanggal_rujukan', '<=', $this->rujukanDateTo);
        }

        if ($this->rujukanRsId !== '') {
            $query->where('id_rumah_sakit', $this->rujukanRsId);
        }

        if ($this->rujukanStatus !== '') {
            $query->where('status', $this->rujukanStatus);
        }

        return $query;
    }

    public function getRujukanMetrics(): array
    {
        $base = $this->getRujukanQuery();

        $total = (clone $base)->count();
        $disetujui = (clone $base)->where('status', StatusRujukan::Disetujui->value)->count();
        $selesai = (clone $base)->where('status', StatusRujukan::Selesai->value)->count();
        $pending = (clone $base)->where('status', StatusRujukan::Pending->value)->count();
        $ditolak = (clone $base)->where('status', StatusRujukan::Ditolak->value)->count();

        $detailStats = (clone $base)
            ->join('detail_rujukan', 'rujukan.id_rujukan', '=', 'detail_rujukan.id_rujukan')
            ->selectRaw('SUM(detail_rujukan.jarak) as total_jarak, SUM(detail_rujukan.estimasi_biaya) as total_biaya')
            ->first();

        return [
            'total' => $total,
            'disetujui' => $disetujui,
            'selesai' => $selesai,
            'pending' => $pending,
            'ditolak' => $ditolak,
            'total_jarak' => round((float) ($detailStats->total_jarak ?? 0), 2),
            'total_biaya' => (float) ($detailStats->total_biaya ?? 0),
        ];
    }

    public function getPasienQuery(): Builder
    {
        $query = Pasien::query()
            ->withCount('rujukan')
            ->orderBy('created_at', 'desc');

        if ($this->pasienSearch !== '') {
            $keyword = '%'.$this->pasienSearch.'%';
            $query->where(function (Builder $q) use ($keyword) {
                $q->where('nama', 'like', $keyword)
                    ->orWhere('nik', 'like', $keyword)
                    ->orWhere('no_rm', 'like', $keyword)
                    ->orWhere('alamat', 'like', $keyword);
            });
        }

        if ($this->pasienDateFrom !== '') {
            $query->whereDate('created_at', '>=', $this->pasienDateFrom);
        }

        if ($this->pasienDateTo !== '') {
            $query->whereDate('created_at', '<=', $this->pasienDateTo);
        }

        if ($this->pasienGender !== '') {
            $query->where('jenis_kelamin', $this->pasienGender);
        }

        if ($this->pasienCoordStatus === 'with') {
            $query->whereNotNull('latitude')->whereNotNull('longitude');
        } elseif ($this->pasienCoordStatus === 'without') {
            $query->where(function (Builder $q) {
                $q->whereNull('latitude')->orWhereNull('longitude');
            });
        }

        return $query;
    }

    public function getPasienMetrics(): array
    {
        $base = $this->getPasienQuery();

        $total = (clone $base)->count();
        $lakiLaki = (clone $base)->where('jenis_kelamin', JenisKelamin::LakiLaki->value)->count();
        $perempuan = (clone $base)->where('jenis_kelamin', JenisKelamin::Perempuan->value)->count();
        $berkoordinat = (clone $base)->whereNotNull('latitude')->whereNotNull('longitude')->count();
        $tanpaKoordinat = (clone $base)->where(function (Builder $q) {
            $q->whereNull('latitude')->orWhereNull('longitude');
        })->count();

        return [
            'total' => $total,
            'laki_laki' => $lakiLaki,
            'perempuan' => $perempuan,
            'berkoordinat' => $berkoordinat,
            'tanpa_koordinat' => $tanpaKoordinat,
        ];
    }

    public function openPrint(): void
    {
        $params = ['tab' => $this->activeTab];

        if ($this->activeTab === 'rujukan') {
            if ($this->rujukanSearch !== '') {
                $params['search'] = $this->rujukanSearch;
            }
            if ($this->rujukanDateFrom !== '') {
                $params['date_from'] = $this->rujukanDateFrom;
            }
            if ($this->rujukanDateTo !== '') {
                $params['date_to'] = $this->rujukanDateTo;
            }
            if ($this->rujukanStatus !== '') {
                $params['status'] = $this->rujukanStatus;
            }
            if ($this->rujukanRsId !== '') {
                $params['rs_id'] = $this->rujukanRsId;
            }
        } else {
            if ($this->pasienSearch !== '') {
                $params['search'] = $this->pasienSearch;
            }
            if ($this->pasienDateFrom !== '') {
                $params['date_from'] = $this->pasienDateFrom;
            }
            if ($this->pasienDateTo !== '') {
                $params['date_to'] = $this->pasienDateTo;
            }
            if ($this->pasienGender !== '') {
                $params['gender'] = $this->pasienGender;
            }
            if ($this->pasienCoordStatus !== '') {
                $params['coord_status'] = $this->pasienCoordStatus;
            }
        }

        $url = route('laporan.print', $params);

        $this->dispatch('open-print-window', url: $url);
    }

    public function exportRujukanCsv(): StreamedResponse
    {
        $fileName = 'laporan_rujukan_'.now()->format('Ymd_His').'.csv';
        $rows = $this->getRujukanQuery()->get();

        $headers = [
            'Content-type' => 'text/csv; charset=UTF-8',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            // Add UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, [
                'No.',
                'No. Rujukan',
                'Tanggal',
                'Nama Pasien',
                'NIK Pasien',
                'No. RM',
                'Rumah Sakit Tujuan',
                'Jarak (km)',
                'Waktu Tempuh (menit)',
                'Estimasi Biaya (Rp)',
                'Status',
                'Dokter Perujuk',
                'Keterangan',
            ]);

            foreach ($rows as $index => $row) {
                fputcsv($handle, [
                    $index + 1,
                    $row->no_rujukan,
                    $row->tanggal_rujukan ? $row->tanggal_rujukan->format('d/m/Y H:i') : '-',
                    $row->pasien?->nama ?? '-',
                    $row->pasien?->nik ?? '-',
                    $row->pasien?->no_rm ?? '-',
                    $row->rumahSakit?->nama_rumah_sakit ?? '-',
                    $row->detailRujukan?->jarak ? number_format($row->detailRujukan->jarak, 2) : '0',
                    $row->detailRujukan?->waktu_tempuh ?? '0',
                    $row->detailRujukan?->estimasi_biaya ? number_format($row->detailRujukan->estimasi_biaya, 0, ',', '.') : '0',
                    $row->status ? $row->status->label() : '-',
                    $row->user?->name ?? '-',
                    $row->keterangan ?? '-',
                ]);
            }

            fclose($handle);
        }, $fileName, $headers);
    }

    public function exportPasienCsv(): StreamedResponse
    {
        $fileName = 'laporan_pasien_'.now()->format('Ymd_His').'.csv';
        $rows = $this->getPasienQuery()->get();

        $headers = [
            'Content-type' => 'text/csv; charset=UTF-8',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            // Add UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, [
                'No.',
                'No. RM',
                'NIK',
                'Nama Pasien',
                'Jenis Kelamin',
                'Tanggal Lahir',
                'No. Telepon',
                'Alamat',
                'Latitude',
                'Longitude',
                'Jumlah Rujukan',
                'Tanggal Terdaftar',
            ]);

            foreach ($rows as $index => $row) {
                fputcsv($handle, [
                    $index + 1,
                    $row->no_rm ?? '-',
                    $row->nik ?? '-',
                    $row->nama,
                    $row->jenis_kelamin ? $row->jenis_kelamin->label() : '-',
                    $row->tanggal_lahir ? $row->tanggal_lahir->format('d/m/Y') : '-',
                    $row->no_telepon ?? '-',
                    $row->alamat ?? '-',
                    $row->latitude ?? '-',
                    $row->longitude ?? '-',
                    $row->rujukan_count ?? 0,
                    $row->created_at ? $row->created_at->format('d/m/Y H:i') : '-',
                ]);
            }

            fclose($handle);
        }, $fileName, $headers);
    }

    public function render(): View
    {
        $rumahSakitList = RumahSakit::query()->orderBy('nama_rumah_sakit')->get(['id_rumah_sakit', 'nama_rumah_sakit']);

        $rujukanData = $this->activeTab === 'rujukan'
            ? $this->getRujukanQuery()->paginate($this->rujukanPerPage, ['*'], 'rujukanPage')
            : null;

        $rujukanMetrics = $this->activeTab === 'rujukan'
            ? $this->getRujukanMetrics()
            : [];

        $pasienData = $this->activeTab === 'pasien'
            ? $this->getPasienQuery()->paginate($this->pasienPerPage, ['*'], 'pasienPage')
            : null;

        $pasienMetrics = $this->activeTab === 'pasien'
            ? $this->getPasienMetrics()
            : [];

        return view('livewire.handler.laporan.index', [
            'rumahSakitList' => $rumahSakitList,
            'rujukanData' => $rujukanData,
            'rujukanMetrics' => $rujukanMetrics,
            'pasienData' => $pasienData,
            'pasienMetrics' => $pasienMetrics,
            'statusOptions' => StatusRujukan::cases(),
            'genderOptions' => JenisKelamin::cases(),
        ]);
    }
}
