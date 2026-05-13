<?php

/** Goal: Melakukan export data transaksi poin ke Excel dengan memisahkan sheet untuk tiap teknisi, Caller: ExportPointTransactions.php, Deps: PointTransactions */

namespace App\Exports;

use App\Models\PointTransactions;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class TechPointTransactionExport implements WithMultipleSheets
{
    use Exportable;

    public string $transactionID;

    public function __construct(string $transactionID)
    {
        $this->transactionID = $transactionID;
    }

    public function sheets(): array
    {
        $sheets = [];

        // Mengambil semua transaksi poin berdasarkan transaction_id
        $transactions = PointTransactions::with(['point', 'pegawai', 'redeemedby'])
            ->where('transaction_id', $this->transactionID)
            ->get();

        // Membuat sheet terpisah untuk setiap transaksi/pegawai
        foreach ($transactions as $transaction) {
            $sheets[] = new TechPointTransactionPerPegawaiSheet($transaction);
        }

        return $sheets;
    }
}

class TechPointTransactionPerPegawaiSheet implements FromView, ShouldAutoSize, WithEvents, WithTitle
{
    public PointTransactions $transaction;

    public function __construct(PointTransactions $transaction)
    {
        $this->transaction = $transaction;
    }

    public function view(): View
    {
        return view('report.point-transaction', [
            // Membungkus transaksi tunggal dalam collection agar kompatibel dengan perulangan @foreach di view
            'data' => collect([$this->transaction]),
        ]);
    }

    public function title(): string
    {
        $name = $this->transaction->pegawai->full_name ?? $this->transaction->kode_pegawai;

        // Membersihkan karakter yang tidak diizinkan oleh Excel untuk nama sheet dan membatasi maksimal 31 karakter
        $cleanName = str_replace(['*', ':', '/', '\\', '?', '[', ']'], '', $name);

        return substr($cleanName, 0, 31);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Set orientasi dan ukuran kertas
                $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_PORTRAIT);
                $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);

                // Terapkan perataan dan pembungkus teks otomatis (word wrap)
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
                    'alignment' => [
                        'wrapText' => true,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Menyesuaikan tinggi baris secara otomatis
                for ($row = 1; $row <= $highestRow; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(-1);
                }
            },
        ];
    }
}
