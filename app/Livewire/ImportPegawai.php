<?php

/** Goal: Livewire component for importing pegawai data via Excel modal, Caller: pegawai/index.blade.php, Deps: PegawaiImport, PegawaiImportTemplate */

namespace App\Livewire;

use App\Exports\PegawaiImportTemplate;
use App\Imports\PegawaiImport;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ImportPegawai extends Component
{
    use WithFileUploads;

    public bool $showModal = false;

    public $file;

    public bool $isImporting = false;

    /** @var array{updated: int, skipped: array<int, string>, failures: array<int, string>}|null */
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

        $import = new PegawaiImport;
        Excel::import($import, $this->file->getRealPath());

        $failures = [];
        foreach ($import->failures() as $failure) {
            $failures[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
        }

        $this->importResult = [
            'updated' => $import->getUpdatedCount(),
            'skipped' => $import->getSkippedRows(),
            'failures' => $failures,
        ];

        $this->isImporting = false;
        $this->reset('file');

        $this->dispatch('pg:eventRefresh-PegawaiTable');
    }

    public function downloadTemplate(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new PegawaiImportTemplate, 'template_import_pegawai.xlsx');
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.import-pegawai');
    }
}
