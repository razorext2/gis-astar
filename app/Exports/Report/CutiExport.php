<?php

/** Goal: Export data cuti ke Excel, Caller: ExportReportJob, Deps: LeaveRequest model, User, Spatie Role */

namespace App\Exports\Report;

use App\Models\LeaveRequest\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class CutiExport implements FromView, ShouldAutoSize, WithEvents
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
        $dateType = $this->additionalFilters['date_type'] ?? 'created_at';

        $query = LeaveRequest::with(['user:id,name,kode_pegawai', 'leaveType:id,name', 'backupPerson:id,name']);

        if ($dateType === 'leave_date') {
            // Overlapping date range filter: start_date <= toDate AND end_date >= fromDate
            $query->where('start_date', '<=', Carbon::parse($this->toDate)->toDateString())
                ->where('end_date', '>=', Carbon::parse($this->fromDate)->toDateString());
        } else {
            $query->where('created_at', '>=', Carbon::parse($this->fromDate)->startOfDay())
                ->where('created_at', '<=', Carbon::parse($this->toDate)->endOfDay());
        }

        if ($this->filterBy && $this->filterValue) {
            if ($this->filterBy === 'user_id') {
                $ids = array_filter(explode(',', $this->filterValue));
                if (! empty($ids)) {
                    $query->whereIn('user_id', $ids);
                }
            } else {
                $query->where($this->filterBy, $this->filterValue);
            }
        }

        if (! empty($this->additionalFilters)) {
            // 1. Spatie Role Filter
            if (! empty($this->additionalFilters['role_id'])) {
                $query->whereHas('user', function ($q) {
                    $q->whereHas('roles', function ($qr) {
                        $qr->where('id', $this->additionalFilters['role_id']);
                    });
                });
            }

            // 2. Status Cuti Filter (e.g. approved, rejected, canceled, pending_spv, pending_backup, pending_hrd, pending_management)
            if (! empty($this->additionalFilters['status'])) {
                $query->where('status', $this->additionalFilters['status']);
            }
        }

        return view('report.export.cuti', [
            'data' => $query->orderBy('created_at', 'asc')->get(),
            'fromDate' => $this->fromDate,
            'toDate' => $this->toDate,
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
