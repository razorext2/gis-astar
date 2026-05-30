<?php

/** Goal: Export data SPK ke Excel/PDF, Caller: ExportReportJob, Deps: SpkMain model */

namespace App\Exports\Report;

use App\Models\Spk\SpkMain;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class SpkExport implements FromView, ShouldAutoSize, WithEvents
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
        $query = SpkMain::with(['addedBy:id,name', 'assignTo:id,name', 'approvedBy:id,name'])
            ->where('created_at', '>=', Carbon::parse($this->fromDate)->startOfDay())
            ->where('created_at', '<=', Carbon::parse($this->toDate)->endOfDay());

        if ($this->filterBy && !is_null($this->filterValue) && $this->filterValue !== '') {
            $query->where($this->filterBy, $this->filterValue);
        }

        if ($this->additionalFilters) {
            if (isset($this->additionalFilters['tipe_tagihan']) && $this->additionalFilters['tipe_tagihan'] !== null && $this->additionalFilters['tipe_tagihan'] !== '') {
                $query->where('tipe_tagihan', $this->additionalFilters['tipe_tagihan']);
            }
            if (isset($this->additionalFilters['tipe_timbangan']) && $this->additionalFilters['tipe_timbangan'] !== null && $this->additionalFilters['tipe_timbangan'] !== '') {
                $query->where('tipe_timbangan', $this->additionalFilters['tipe_timbangan']);
            }
            if (isset($this->additionalFilters['status']) && $this->additionalFilters['status'] !== null && $this->additionalFilters['status'] !== '') {
                $query->where('status', $this->additionalFilters['status']);
            }
            if (isset($this->additionalFilters['status_approval']) && $this->additionalFilters['status_approval'] !== null && $this->additionalFilters['status_approval'] !== '') {
                $query->where('status_approval', $this->additionalFilters['status_approval']);
            }
        }

        return view('report.export.spk', [
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
