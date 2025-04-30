<?php

namespace App\Exports;

use App\Models\Sales;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class SalesExport implements FromView, ShouldAutoSize, WithEvents
{
    use Exportable;

    protected $fromDate;
    protected $toDate;
    protected $role;
    protected $sales;

    public function __construct($fromDate, $toDate, $role, $sales)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->role = $role;
        $this->sales = $sales;
    }
    public function view(): View
    {
        $sales = Sales::with(['userRelasi', 'pegawaiRelasi', 'validateBy'])
            ->where('created_at', '>=', $this->fromDate)
            ->where('created_at', '<=', $this->toDate);

        if ($this->role && $this->role !== 'All') {
            $sales = $sales->whereHas('userRelasi.roles', function ($role) {
                $role->whereIn('name', (array) $this->role);
            });
        }

        if($this->sales) {
            $sales = $sales->where('kode_pegawai', $this->sales);
        }

        $sales = $sales->orderBy('created_at', 'asc')
            ->get();

        return view('report.sales', [
            'fromDate' => $this->fromDate,
            'toDate' => $this->toDate,
            'role' => $this->role,
            'data' => $sales,
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
