<?php

/** Goal: Export template Excel kosong untuk import data pegawai, Caller: ImportPegawai Livewire, Deps: Maatwebsite/Excel */

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PegawaiImportTemplate implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
{
    /**
     * @return array<int, string>
     */
    public function headings(): array
    {
        return [
            'kode_pegawai',
            'full_name',
            'nick_name',
            'no_telp',
            'alamat',
            'tgl_lahir',
            'gender',
            'join_date',
        ];
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function array(): array
    {
        return [
            ['1234', 'Sulaiman', 'Iman', '08123456789', 'Jl. Contoh No. 1', '1990-01-15', 'L', '2024-01-01'],
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
