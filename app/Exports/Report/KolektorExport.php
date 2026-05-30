<?php

/** Goal: Export data kolektor ke Excel/PDF, Caller: ExportReportJob, Deps: Collector model */

namespace App\Exports\Report;

use App\Models\Collector;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class KolektorExport implements FromView, ShouldAutoSize, WithEvents
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
        $query = Collector::with(['pegawaiRelasi:kode_pegawai,full_name', 'filledBy:id,name', 'validatedBy:id,name'])
            ->where('created_at', '>=', Carbon::parse($this->fromDate)->startOfDay())
            ->where('created_at', '<=', Carbon::parse($this->toDate)->endOfDay());

        if ($this->filterBy && $this->filterValue) {
            $query->where($this->filterBy, $this->filterValue);
        }

        if ($this->additionalFilters) {
            if (!empty($this->additionalFilters['bill_type'])) {
                $query->where('bill_type', $this->additionalFilters['bill_type']);
            }
            if (isset($this->additionalFilters['have_paid']) && $this->additionalFilters['have_paid'] !== null && $this->additionalFilters['have_paid'] !== '') {
                $query->where('have_paid', $this->additionalFilters['have_paid']);
            }
            if (isset($this->additionalFilters['status']) && $this->additionalFilters['status'] !== null && $this->additionalFilters['status'] !== '') {
                $query->where('status', $this->additionalFilters['status']);
            }
        }

        return view('report.export.kolektor', [
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
