<?php

/** Goal: Export data absensi ke Excel/PDF, Caller: ExportReportJob, Deps: Attendance model */

namespace App\Exports\Report;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class AbsensiExport implements FromView, ShouldAutoSize, WithEvents
{
    use Exportable;

    public function __construct(
        protected string $fromDate,
        protected string $toDate,
        protected ?string $filterBy = null,
        protected ?string $filterValue = null,
        protected ?array $additionalFilters = null,
    ) {}

    public function view(): View
    {
        $attendanceType = $this->additionalFilters['attendance_type'] ?? 'masuk';

        if ($attendanceType === 'semua') {
            // 1. Query for Check-In
            $queryMasuk = \App\Models\Attendance::with(['pegawaiRelasi:kode_pegawai,full_name', 'verifiedBy:id,name'])
                ->where('created_at', '>=', Carbon::parse($this->fromDate)->startOfDay())
                ->where('created_at', '<=', Carbon::parse($this->toDate)->endOfDay());

            // 2. Query for Check-Out
            $queryKeluar = \App\Models\AttendanceOut::with(['pegawaiRelasi:kode_pegawai,full_name', 'verifiedBy:id,name'])
                ->where('created_at', '>=', Carbon::parse($this->fromDate)->startOfDay())
                ->where('created_at', '<=', Carbon::parse($this->toDate)->endOfDay());

            if ($this->filterBy && $this->filterValue) {
                if ($this->filterBy === 'kode_pegawai') {
                    $codes = array_filter(explode(',', $this->filterValue));
                    if (! empty($codes)) {
                        $queryMasuk->whereIn('kode_pegawai', $codes);
                        $queryKeluar->whereIn('kode_pegawai', $codes);
                    }
                } else {
                    $queryMasuk->where($this->filterBy, $this->filterValue);
                    $queryKeluar->where($this->filterBy, $this->filterValue);
                }
            }

            if (! empty($this->additionalFilters)) {
                if (! empty($this->additionalFilters['role_id'])) {
                    $roleFilter = function ($q) {
                        $q->whereHas('roles', function ($qr) {
                            $qr->where('id', $this->additionalFilters['role_id']);
                        });
                    };
                    $queryMasuk->whereHas('user', $roleFilter);
                    $queryKeluar->whereHas('user', $roleFilter);
                }

                if (isset($this->additionalFilters['position_status']) && $this->additionalFilters['position_status'] !== '') {
                    $queryMasuk->where('position_status', $this->additionalFilters['position_status']);
                    $queryKeluar->where('position_status', $this->additionalFilters['position_status']);
                }

                if (isset($this->additionalFilters['verified']) && $this->additionalFilters['verified'] !== '') {
                    $queryMasuk->where('verified', $this->additionalFilters['verified']);
                    $queryKeluar->where('verified', $this->additionalFilters['verified']);
                }
            }

            $masuk = $queryMasuk->get()->map(function ($item) {
                $item->attendance_flow_type = 'masuk';

                return $item;
            });
            $keluar = $queryKeluar->get()->map(function ($item) {
                $item->attendance_flow_type = 'keluar';

                return $item;
            });

            $data = $masuk->concat($keluar)->sortBy('created_at')->values();
        } else {
            $modelClass = $attendanceType === 'keluar' ? \App\Models\AttendanceOut::class : \App\Models\Attendance::class;

            $query = $modelClass::with(['pegawaiRelasi:kode_pegawai,full_name', 'verifiedBy:id,name'])
                ->where('created_at', '>=', Carbon::parse($this->fromDate)->startOfDay())
                ->where('created_at', '<=', Carbon::parse($this->toDate)->endOfDay());

            if ($this->filterBy && $this->filterValue) {
                if ($this->filterBy === 'kode_pegawai') {
                    $codes = array_filter(explode(',', $this->filterValue));
                    if (! empty($codes)) {
                        $query->whereIn('kode_pegawai', $codes);
                    }
                } else {
                    $query->where($this->filterBy, $this->filterValue);
                }
            }

            if (! empty($this->additionalFilters)) {
                // 1. Role Filter
                if (! empty($this->additionalFilters['role_id'])) {
                    $query->whereHas('user', function ($q) {
                        $q->whereHas('roles', function ($qr) {
                            $qr->where('id', $this->additionalFilters['role_id']);
                        });
                    });
                }

                // 2. Position Status Filter
                if (isset($this->additionalFilters['position_status']) && $this->additionalFilters['position_status'] !== '') {
                    $query->where('position_status', $this->additionalFilters['position_status']);
                }

                // 3. Verified Status Filter
                if (isset($this->additionalFilters['verified']) && $this->additionalFilters['verified'] !== '') {
                    $query->where('verified', $this->additionalFilters['verified']);
                }
            }

            $data = $query->orderBy('created_at', 'asc')->get()->map(function ($item) use ($attendanceType) {
                $item->attendance_flow_type = $attendanceType;

                return $item;
            });
        }

        return view('report.export.absensi', [
            'data' => $data,
            'fromDate' => $this->fromDate,
            'toDate' => $this->toDate,
            'attendanceType' => $attendanceType,
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
                    'alignment' => [
                        'wrapText' => true,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                for ($row = 1; $row <= $highestRow; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(-1);
                }
            },
        ];
    }
}
