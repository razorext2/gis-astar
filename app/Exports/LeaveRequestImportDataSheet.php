<?php

/** Goal: Sheet data template import cuti dengan heading dan contoh, Caller: LeaveRequestImportTemplate, Deps: Maatwebsite/Excel */

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LeaveRequestImportDataSheet implements FromArray, ShouldAutoSize, WithHeadings, WithStyles, WithTitle
{
    public function title(): string
    {
        return 'Data Import';
    }

    /**
     * @return array<int, string>
     */
    public function headings(): array
    {
        return [
            'kode_pegawai',
            'kode_cuti',
            'tanggal_mulai',
            'tanggal_selesai',
            'total_hari',
            'alasan',
        ];
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function array(): array
    {
        return [
            ['344', 'CT-TAHUNAN', '2025-01-15', '2025-01-20', '4', 'Liburan keluarga'],
            ['344', 'CT-KMLNGN', '2025-03-10', '2025-03-11', '2', 'Kemalangan keluarga'],
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4'],
                ],
            ],
        ];
    }
}
