<?php
/** Goal: Manage national holidays, including fetching from API. Caller: Routes, Deps: Holiday model, HolidayService */

namespace App\Livewire\Handler\System\Holiday;

use App\Models\System\Holiday;
use App\Services\System\HolidayService;
use App\Livewire\Concerns\HandlesErrors;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Libur Nasional')]
class Index extends Component
{
    use HandlesErrors;

    public $showCreateModal = false;
    public $year;
    public $holidayOptions = [];
    public $selectedHolidays = [];
    public $existingHolidays = [];

    public function mount()
    {
        $this->year = date('Y');
    }

    public function fetchHolidays(HolidayService $service)
    {
        $this->validate([
            'year' => 'required|numeric|min:2020|max:2099',
        ]);

        $this->runSafely(function () use ($service) {
            $this->holidayOptions = $service->fetchFromApi((int)$this->year);
            $this->existingHolidays = $service->getExistingDates((int)$this->year);
            $this->selectedHolidays = []; // Reset selection
        }, 'Gagal mengambil data dari API.');
    }

    public function saveHolidays(HolidayService $service)
    {
        if (empty($this->selectedHolidays)) {
            $this->dispatch('swal', title: 'Peringatan', text: 'Silakan pilih setidaknya satu hari libur.', icon: 'warning');
            return;
        }

        $this->runSafely(function () use ($service) {
            $toSave = collect($this->holidayOptions)
                ->filter(fn($h) => in_array($h['date'], $this->selectedHolidays))
                ->toArray();

            $service->storeHolidays($toSave);

            $this->showCreateModal = false;
            $this->holidayOptions = [];
            $this->selectedHolidays = [];
            
            $this->dispatch('pg:eventRefresh-HolidayTable');
            $this->dispatch('swal', title: 'Berhasil', text: 'Hari libur nasional berhasil disimpan.', icon: 'success');
        }, 'Gagal menyimpan data hari libur.');
    }

    public function render()
    {
        return view('livewire.handler.system.holiday.index');
    }
}
