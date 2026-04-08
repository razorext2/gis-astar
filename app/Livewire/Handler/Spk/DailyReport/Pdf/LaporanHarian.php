<?php

namespace App\Livewire\Handler\Spk\DailyReport\Pdf;

use Livewire\Component;

class LaporanHarian extends Component
{
    public bool $showPreview = false;

    public ?string $assignmentId = null;

    public function mount($assignmentId)
    {
        $this->assignmentId = $assignmentId;
    }

    public function previewPdf()
    {
        // munculkan modal summary
        $this->showPreview = true;

        // munculkan modal pdf
        $this->dispatch('show-pdf-modal', url: route('daily-report.pdf.stream', ['assignmentId' => $this->assignmentId]));
    }

    public function render()
    {
        return view('livewire.handler.spk.daily-report.pdf.laporan-harian');
    }
}
