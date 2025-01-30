<?php

namespace App\Exports;

use App\Models\Collector;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class CollectorExport implements FromView, ShouldAutoSize, WithEvents
{
    use Exportable;

    protected $date;
    protected $status;
    protected $type;

    public function __construct($date, $status, $type)
    {
        $this->date = $date;
        $this->status = $status;
        $this->type = $type;
    }

    public function view(): View
    {
        $collectors = Collector::query()
            ->with(['collectTaskRelasi', 'collectTaskPpnRelasi'])
            ->whereDate('assign_date', $this->date)
            ->where('status', $this->status)
            ->where('bill_type', $this->type)
            ->get();

        return view('report.collector', [
            'type' => $this->type,
            'items' => $collectors,
            'date' => Carbon::parse($this->date)->locale('id_ID')->isoFormat('dddd, D MMMM Y'),
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Set page orientation to landscape and paper size to A4
                $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

                // Apply word wrap and vertical alignment to all cells
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
                    'alignment' => [
                        'wrapText' => true,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Adjust row height automatically
                for ($row = 1; $row <= $highestRow; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(-1);
                }
            },
        ];
    }
}
