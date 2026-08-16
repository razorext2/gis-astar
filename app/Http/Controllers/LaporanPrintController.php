<?php

/** Goal: Cetak Laporan Pasien & Riwayat Rujukan sebagai halaman print-only tanpa layout app */

namespace App\Http\Controllers;

use App\Enums\JenisKelamin;
use App\Enums\StatusRujukan;
use App\Models\Pasien;
use App\Models\Rujukan;
use App\Models\RumahSakit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanPrintController extends Controller
{
    public function __invoke(Request $request): View
    {
        $tab = $request->input('tab', 'rujukan');

        $rumahSakitList = RumahSakit::query()
            ->orderBy('nama_rumah_sakit')
            ->get(['id_rumah_sakit', 'nama_rumah_sakit']);

        $rujukanData = null;
        $rujukanMetrics = [];
        $pasienData = null;
        $pasienMetrics = [];

        if ($tab === 'rujukan') {
            $query = $this->buildRujukanQuery($request);
            $rujukanData = $query->get();
            $rujukanMetrics = $this->computeRujukanMetrics($request);
        } else {
            $query = $this->buildPasienQuery($request);
            $pasienData = $query->get();
            $pasienMetrics = $this->computePasienMetrics($request);
        }

        return view('laporan.print', [
            'activeTab' => $tab,
            'rujukanData' => $rujukanData,
            'rujukanMetrics' => $rujukanMetrics,
            'pasienData' => $pasienData,
            'pasienMetrics' => $pasienMetrics,
            'rumahSakitList' => $rumahSakitList,
            'filters' => [
                'search' => $request->input('search', ''),
                'date_from' => $request->input('date_from', ''),
                'date_to' => $request->input('date_to', ''),
                'status' => $request->input('status', ''),
                'rs_id' => $request->input('rs_id', ''),
                'gender' => $request->input('gender', ''),
                'coord_status' => $request->input('coord_status', ''),
            ],
            'statusOptions' => StatusRujukan::cases(),
            'genderOptions' => JenisKelamin::cases(),
        ]);
    }

    private function buildRujukanQuery(Request $request): Builder
    {
        $query = Rujukan::query()
            ->with(['pasien', 'rumahSakit', 'user', 'detailRujukan'])
            ->orderBy('tanggal_rujukan', 'desc');

        $search = $request->input('search', '');
        if ($search !== '') {
            $keyword = '%'.$search.'%';
            $query->where(function (Builder $q) use ($keyword) {
                $q->where('no_rujukan', 'like', $keyword)
                    ->orWhereHas('pasien', fn (Builder $q2) => $q2->where('nama', 'like', $keyword)
                        ->orWhere('nik', 'like', $keyword)
                        ->orWhere('no_rm', 'like', $keyword))
                    ->orWhereHas('rumahSakit', fn (Builder $q2) => $q2->where('nama_rumah_sakit', 'like', $keyword));
            });
        }

        $dateFrom = $request->input('date_from', '');
        if ($dateFrom !== '') {
            $query->whereDate('tanggal_rujukan', '>=', $dateFrom);
        }

        $dateTo = $request->input('date_to', '');
        if ($dateTo !== '') {
            $query->whereDate('tanggal_rujukan', '<=', $dateTo);
        }

        $rsId = $request->input('rs_id', '');
        if ($rsId !== '') {
            $query->where('id_rumah_sakit', $rsId);
        }

        $status = $request->input('status', '');
        if ($status !== '') {
            $query->where('status', $status);
        }

        return $query;
    }

    private function buildPasienQuery(Request $request): Builder
    {
        $query = Pasien::query()
            ->withCount('rujukan')
            ->orderBy('created_at', 'desc');

        $search = $request->input('search', '');
        if ($search !== '') {
            $keyword = '%'.$search.'%';
            $query->where(function (Builder $q) use ($keyword) {
                $q->where('nama', 'like', $keyword)
                    ->orWhere('nik', 'like', $keyword)
                    ->orWhere('no_rm', 'like', $keyword)
                    ->orWhere('alamat', 'like', $keyword);
            });
        }

        $dateFrom = $request->input('date_from', '');
        if ($dateFrom !== '') {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        $dateTo = $request->input('date_to', '');
        if ($dateTo !== '') {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $gender = $request->input('gender', '');
        if ($gender !== '') {
            $query->where('jenis_kelamin', $gender);
        }

        $coordStatus = $request->input('coord_status', '');
        if ($coordStatus === 'with') {
            $query->whereNotNull('latitude')->whereNotNull('longitude');
        } elseif ($coordStatus === 'without') {
            $query->where(function (Builder $q) {
                $q->whereNull('latitude')->orWhereNull('longitude');
            });
        }

        return $query;
    }

    private function computeRujukanMetrics(Request $request): array
    {
        $base = $this->buildRujukanQuery($request);

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

    private function computePasienMetrics(Request $request): array
    {
        $base = $this->buildPasienQuery($request);

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
}
