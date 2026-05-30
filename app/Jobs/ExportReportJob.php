<?php

/** Goal: Generic background job untuk export semua tipe laporan, Caller: Livewire Export Components, Deps: Export classes, ReportExportCompleted, ReportExportCompletedEvent */

namespace App\Jobs;

use App\Events\ReportExportCompletedEvent;
use App\Exports\Report\AbsensiExport;
use App\Exports\Report\CutiExport;
use App\Exports\Report\DriverExport;
use App\Exports\Report\InvoiceReportExport;
use App\Exports\Report\KolektorExport;
use App\Exports\Report\PiutangExport;
use App\Exports\Report\SalesReportExport;
use App\Exports\Report\SpkExport;
use App\Models\User;
use App\Notifications\ReportExportCompleted;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ExportReportJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 600;

    /**
     * @param  array{label: string, column: string, relation: string|null}|null  $filterConfig
     */
    public function __construct(
        public int $userId,
        public string $reportType,
        public string $fromDate,
        public string $toDate,
        public ?string $filterBy,
        public ?string $filterValue,
        public string $exportFormat = 'xlsx',
        public ?array $additionalFilters = null,
    ) {}

    public function handle(): void
    {
        try {
            $exportClass = $this->resolveExportClass();
            $rand = \Illuminate\Support\Str::random(16);
            $typeLabel = str_replace(' ', '-', strtolower($this->getReportLabel()));

            if ($this->exportFormat === 'pdf') {
                $fileName = "{$rand}-laporan-{$typeLabel}-{$this->fromDate}-{$this->toDate}.pdf";
                $filePath = "export/report/{$fileName}";

                $view = $exportClass->view();
                $pdf = Pdf::loadHTML($view->render())
                    ->setPaper('a4', 'landscape');

                Storage::put($filePath, $pdf->output());
            } else {
                $fileName = "{$rand}-laporan-{$typeLabel}-{$this->fromDate}-{$this->toDate}.xlsx";
                $filePath = "export/report/{$fileName}";

                $exportClass->store($filePath);
            }

            $user = User::find($this->userId);

            $user->notify(new ReportExportCompleted(
                $fileName,
                $this->getReportLabel(),
                $this->fromDate,
                $this->toDate,
            ));

            $notification = $user->notifications()->latest()->first();
            $notificationId = $notification ? $notification->id : (string) \Illuminate\Support\Str::uuid();

            broadcast(new ReportExportCompletedEvent(
                $notificationId,
                $this->userId,
                $fileName,
                $this->getReportLabel(),
                $this->fromDate,
                $this->toDate,
            ));
        } catch (\Exception $e) {
            Log::error("Export report [{$this->reportType}] failed for user: {$this->userId} - Error: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * @return \Maatwebsite\Excel\Concerns\FromView&\Maatwebsite\Excel\Concerns\Exportable
     */
    private function resolveExportClass(): mixed
    {
        $map = [
            'absensi' => AbsensiExport::class,
            'cuti' => CutiExport::class,
            'piutang' => PiutangExport::class,
            'kolektor' => KolektorExport::class,
            'invoice' => InvoiceReportExport::class,
            'spk' => SpkExport::class,
            'driver' => DriverExport::class,
            'sales' => SalesReportExport::class,
        ];

        $class = $map[$this->reportType] ?? null;

        if (! $class) {
            throw new \InvalidArgumentException("Report type [{$this->reportType}] is not supported.");
        }

        return new $class(
            $this->fromDate,
            $this->toDate,
            $this->filterBy,
            $this->filterValue,
            $this->additionalFilters,
        );
    }

    private function getReportLabel(): string
    {
        $labels = [
            'absensi' => 'Absensi',
            'cuti' => 'Cuti',
            'piutang' => 'Piutang',
            'kolektor' => 'Kolektor',
            'invoice' => 'Invoice',
            'spk' => 'SPK',
            'driver' => 'Driver',
            'sales' => 'Sales',
        ];

        return $labels[$this->reportType] ?? $this->reportType;
    }
}
