<?php

/** Goal: Export data piutang ke Excel, Caller: ExportReportJob, Deps: CollectTask model, Pegawai, User */

namespace App\Exports\Report;

use App\Models\CollectTask;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class PiutangExport implements FromView, ShouldAutoSize, WithEvents
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
        $srType = $this->additionalFilters['sr_type'] ?? null;
        $billStatus = $this->additionalFilters['bill_status'] ?? null;

        $query = CollectTask::with(['pegawaiRelasi:kode_pegawai,full_name', 'userRelasi:id,name,kode_pegawai']);

        if ($dateType === 'assign_date') {
            $query->where('assign_date', '>=', Carbon::parse($this->fromDate)->toDateString())
                ->where('assign_date', '<=', Carbon::parse($this->toDate)->toDateString());
        } else {
            $query->where('created_at', '>=', Carbon::parse($this->fromDate)->startOfDay())
                ->where('created_at', '<=', Carbon::parse($this->toDate)->endOfDay());
        }

        if ($this->filterBy && $this->filterValue) {
            $query->where($this->filterBy, $this->filterValue);
        }

        if ($srType) {
            $query->where('sr_type', $srType);
        }

        if ($billStatus !== null && $billStatus !== '') {
            $query->where('bill_status', $billStatus);
        }

        return view('report.export.piutang', [
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
                    'alignment' => ['wrapText' => true, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);

                for ($row = 1; $row <= $highestRow; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(-1);
                }
            },
        ];
    }
}
