<?php

namespace App\Exports;

use App\Models\PointTransactions;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class TechPointTransactionExport implements FromView, ShouldAutoSize, WithEvents
{
    use Exportable;

    public $transactionID;

    public function __construct($transactionID)
    {
        $this->transactionID = $transactionID;
    }

    public function view(): View
    {
        $data = PointTransactions::with('point')
            ->where('transaction_id', $this->transactionID)
            ->get();

        return view('report.point-transaction', [
            'data' => $data,
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // set page orientation to landscape and paper size to A4
                $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_PORTRAIT);
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
