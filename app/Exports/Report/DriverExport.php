<?php

/** Goal: Export data driver ke Excel/PDF, Caller: ExportReportJob, Deps: Driver model */

namespace App\Exports\Report;

use App\Models\Driver;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class DriverExport implements FromView, ShouldAutoSize, WithEvents
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
        $query = Driver::with(['pegawai:kode_pegawai,full_name', 'user:id,name,kode_pegawai', 'assignBy:id,name', 'validateBy:id,name'])
            ->where('created_at', '>=', Carbon::parse($this->fromDate)->startOfDay())
            ->where('created_at', '<=', Carbon::parse($this->toDate)->endOfDay());

        if ($this->filterBy && !is_null($this->filterValue) && $this->filterValue !== '') {
            $query->where($this->filterBy, $this->filterValue);
        }

        if ($this->additionalFilters) {
            if (isset($this->additionalFilters['tipe_tagihan']) && $this->additionalFilters['tipe_tagihan'] !== null && $this->additionalFilters['tipe_tagihan'] !== '') {
                $query->where('tipe_tagihan', $this->additionalFilters['tipe_tagihan']);
            }
            if (isset($this->additionalFilters['tipe_kunjungan']) && $this->additionalFilters['tipe_kunjungan'] !== null && $this->additionalFilters['tipe_kunjungan'] !== '') {
                $query->where('tipe_kunjungan', $this->additionalFilters['tipe_kunjungan']);
            }
            if (isset($this->additionalFilters['kode_pegawai']) && !empty($this->additionalFilters['kode_pegawai'])) {
                $val = $this->additionalFilters['kode_pegawai'];
                if (is_array($val)) {
                    $query->whereIn('kode_pegawai', $val);
                } else {
                    $query->whereIn('kode_pegawai', array_filter(explode(',', $val)));
                }
            }
            if (isset($this->additionalFilters['assign_by']) && !empty($this->additionalFilters['assign_by'])) {
                $val = $this->additionalFilters['assign_by'];
                if (is_array($val)) {
                    $query->whereIn('assign_by', $val);
                } else {
                    $query->whereIn('assign_by', array_filter(explode(',', $val)));
                }
            }
            if (isset($this->additionalFilters['status']) && $this->additionalFilters['status'] !== null && $this->additionalFilters['status'] !== '') {
                $query->where('status', $this->additionalFilters['status']);
            }
            if (isset($this->additionalFilters['status_pengantaran']) && $this->additionalFilters['status_pengantaran'] !== null && $this->additionalFilters['status_pengantaran'] !== '') {
                $query->where('status_pengantaran', $this->additionalFilters['status_pengantaran']);
            }
        }

        return view('report.export.driver', [
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
