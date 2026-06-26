<?php

/** Goal: Livewire component for importing historical leave data via Excel modal, Caller: manage-balances/index.blade.php, Deps: LeaveRequestImport, LeaveRequestImportTemplate */

namespace App\Livewire\Handler\LeaveRequest;

use App\Exports\LeaveRequestImportTemplate;
use App\Imports\LeaveRequestImport;
use App\Livewire\Concerns\HandlesErrors;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ImportLeaveRequest extends Component
{
    use HandlesErrors, WithFileUploads;

    public bool $showModal = false;

    public $file;

    public bool $isImporting = false;

    /** @var array{imported: int, skipped: array<int, string>, failures: array<int, string>}|null */
    public ?array $importResult = null;

    public function openModal(): void
    {
        $this->reset(['file', 'importResult', 'isImporting']);
        $this->resetValidation();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['file', 'importResult', 'isImporting']);
        $this->resetValidation();
    }

    public function import(): void
    {
        $this->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls', 'max:5120'],
        ], [
            'file.required' => 'File Excel wajib dipilih.',
            'file.mimes' => 'File harus berformat .xlsx atau .xls.',
            'file.max' => 'Ukuran file maksimal 5MB.',
        ]);

        $this->isImporting = true;

        $this->runSafely(function () {
            $import = new LeaveRequestImport;
            Excel::import($import, $this->file->getRealPath());

            $failures = [];
            foreach ($import->failures() as $failure) {
                $failures[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }

            $this->importResult = [
                'imported' => $import->getImportedCount(),
                'skipped' => $import->getSkippedRows(),
                'failures' => $failures,
            ];

            $this->reset('file');
        }, 'Gagal mengimport data cuti');

        $this->isImporting = false;
    }

    public function downloadTemplate(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new LeaveRequestImportTemplate, 'template_import_cuti.xlsx');
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.handler.leave-request.import-leave-request');
    }
}
