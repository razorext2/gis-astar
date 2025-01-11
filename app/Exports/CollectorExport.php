<?php

namespace App\Exports;

use App\Models\Collector;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

// class CollectorExport implements FromView, ShouldAutoSize
class CollectorExport implements FromQuery, ShouldAutoSize, WithHeadings
{
    use Exportable;

    protected $date;

    public function __construct($date)
    {
        $this->date = $date;
    }

    public function query()
    {
        return Collector::query()
            ->with('collectTaskRelasi')
            ->whereDate('created_at', $this->date);
    }

    public function headings(): array
    {
        return [
            '#',
            'TT Bawa Bon',
            'Nama Cust',
            'No. Bukti',
            'Nilai',
            'TT',
            'Keterangan',
            'Cara Byr',
            'Jenis Giro',
            'No. Giro',
            'Tgl Cair',
            'Pot(PPH23, Adm)',
            'Nilai'
        ];
    }
}
