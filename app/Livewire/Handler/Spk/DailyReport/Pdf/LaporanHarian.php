<?php

namespace App\Livewire\Handler\Spk\DailyReport\Pdf;

use Livewire\Component;

class LaporanHarian extends Component
{
    public bool $showPreview = false;

    public ?string $pdfUrl = null;

    public ?string $assignmentId = null;

    public function mount($assignmentId)
    {
        $this->assignmentId = $assignmentId;
    }

    public function previewPdf()
    {
        $this->pdfUrl = route('daily-report.pdf.stream', ['assignmentId' => $this->assignmentId]);
        $this->showPreview = true;

        // munculkan modal pdf
        $this->dispatch('show-pdf-modal', url: route('daily-report.pdf.stream', ['assignmentId' => $this->assignmentId]));
    }

    public function render()
    {
        return view('livewire.handler.spk.daily-report.pdf.laporan-harian');
    }
}
