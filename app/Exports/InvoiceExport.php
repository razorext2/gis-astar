<?php

/** Goal: Export invoice ke Excel dengan Maatwebsite, Caller: ExportInvoiceToExcelJob, Deps: Invoice model */

namespace App\Exports;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class InvoiceExport implements FromView, ShouldAutoSize, WithEvents
{
    use Exportable;

    protected $fromDate;
    protected $toDate;
    protected $region;
    protected $tipeTagihan;

    public function __construct($fromDate, $toDate, $region, $tipeTagihan = null)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->region = $region;
        $this->tipeTagihan = $tipeTagihan;
    }

    public function view(): View
    {
        $query = Invoice::with(['addedBy:id,name', 'latestUpdateBy:id,name'])
            ->where('created_at', '>=', Carbon::parse($this->fromDate)->startOfDay())
            ->where('created_at', '<=', Carbon::parse($this->toDate)->endOfDay());

        // Filter by region → tipe_invoice (dalkot = medan, lukot = luar kota)
        if ($this->region && $this->region !== 'all') {
            $tipeInvoiceMap = [
                'medan' => 'dalkot',
                'cust'  => 'lukot',
                'pku'   => 'lukot',
                'jkt'   => 'lukot',
            ];

            if (isset($tipeInvoiceMap[$this->region])) {
                $query->where('tipe_invoice', $tipeInvoiceMap[$this->region]);
            }
        }

        // Filter by tipe tagihan (idcppn / idyppn)
        if ($this->tipeTagihan && $this->tipeTagihan !== 'all') {
            $query->where('tipe_tagihan', $this->tipeTagihan);
        }

        $invoices = $query->orderBy('created_at', 'asc')->get();

        $regionLabels = [
            'all'   => 'Semua Invoice',
            'cust'  => 'Direct Customer',
            'medan' => 'Invoice Medan',
            'pku'   => 'Invoice Pekanbaru',
            'jkt'   => 'Invoice Jakarta',
        ];

        return view('report.invoice', [
            'fromDate' => $this->fromDate,
            'toDate'   => $this->toDate,
            'region'   => $regionLabels[$this->region] ?? 'Semua Invoice',
            'data'     => $invoices,
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // set page orientation to landscape and paper size to A4
                $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);

                // apply word wrap and vertical alignment to all cells
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
                    'alignment' => [
                        'wrapText' => true,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // adjust row height automatically
                for ($row = 1; $row <= $highestRow; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(-1);
                }
            },
        ];
    }
}
