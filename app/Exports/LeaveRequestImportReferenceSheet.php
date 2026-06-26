<?php

/** Goal: Sheet referensi kode cuti untuk template import, Caller: LeaveRequestImportTemplate, Deps: LeaveType, Maatwebsite/Excel */

namespace App\Exports;

use App\Models\LeaveRequest\LeaveType;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LeaveRequestImportReferenceSheet implements FromArray, ShouldAutoSize, WithHeadings, WithStyles, WithTitle
{
    public function title(): string
    {
        return 'Referensi Kode Cuti';
    }

    /**
     * @return array<int, string>
     */
    public function headings(): array
    {
        return [
            'kode_cuti',
            'nama_tipe_cuti',
            'default_hari',
            'potong_saldo_tahunan',
        ];
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function array(): array
    {
        return LeaveType::orderBy('id')
            ->get()
            ->map(fn (LeaveType $type) => [
                $type->code,
                $type->name,
                (string) $type->default_days,
                $type->is_anual_deduction ? 'Ya' : 'Tidak',
            ])
            ->toArray();
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '548235'],
                ],
            ],
        ];
    }
}
