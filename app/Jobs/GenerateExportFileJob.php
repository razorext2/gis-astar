<?php

/** Goal: Generate Excel/PDF export files for Dacin AI Chatbot, Caller: GeminiService::executeFunction, Deps: Storage, Str, Excel, Pdf */

namespace App\Jobs;

use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class GenerateExportFileJob
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly array $data,
        public readonly string $format,
        public readonly string $title
    ) {}

    /**
     * Execute the job and return the export details.
     *
     * @return array{download_url: string, format: string, file_name: string}
     */
    public function handle(): array
    {
        if (! Storage::disk('public')->exists('exports')) {
            Storage::disk('public')->makeDirectory('exports');
        }

        $sluggedTitle = Str::slug($this->title);
        $fileName = 'exports/' . $sluggedTitle . '-' . time();
        $format = strtolower($this->format);

        if ($format === 'xlsx') {
            $fileName .= '.xlsx';
            $exportInstance = new class($this->data) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\ShouldAutoSize {
                public function __construct(private array $exportData) {}

                public function collection(): \Illuminate\Support\Collection
                {
                    return collect($this->exportData);
                }

                public function headings(): array
                {
                    $firstRow = reset($this->exportData);
                    return $firstRow ? array_keys((array) $firstRow) : [];
                }
            };

            Excel::store($exportInstance, $fileName, 'public');
        } elseif ($format === 'pdf') {
            $fileName .= '.pdf';
            $firstRow = reset($this->data);
            $headings = $firstRow ? array_keys((array) $firstRow) : [];

            $pdf = Pdf::loadView('exports.pdf', [
                'title' => $this->title,
                'headings' => $headings,
                'data' => $this->data,
            ]);
            Storage::disk('public')->put($fileName, $pdf->output());
        } else {
            throw new \InvalidArgumentException("Unsupported format: {$this->format}");
        }

        $downloadUrl = Storage::disk('public')->url($fileName);

        return [
            'download_url' => $downloadUrl,
            'format' => $format,
            'file_name' => basename($fileName),
        ];
    }
}
