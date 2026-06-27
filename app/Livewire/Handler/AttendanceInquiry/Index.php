<?php

/** Goal: Display list of own attendance inquiries, Caller: resources/views/dashboard/attendance-inquiry/index.blade.php, Deps: AttendanceInquiry */

namespace App\Livewire\Handler\AttendanceInquiry;

use App\Models\AttendanceInquiry\AttendanceInquiry;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public $search = '';

    #[Url(as: 'status')]
    public $filterStatus = '';

    public function resetFilters(): void
    {
        $this->reset(['search', 'filterStatus']);
        $this->resetPage();
    }

    public function updated($property): void
    {
        if (in_array($property, ['search', 'filterStatus'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $query = AttendanceInquiry::query()
            ->where('kode_pegawai', auth()->user()->kode_pegawai);

        // Apply Search
        $query->when($this->search, function ($q) {
            $q->where(function ($sub) {
                $sub->where('keterangan', 'like', '%' . $this->search . '%')
                    ->orWhere('no_vt', 'like', '%' . $this->search . '%');
            });
        });

        // Apply Status Filter
        $query->when($this->filterStatus, function ($q) {
            $q->where('status', $this->filterStatus);
        });

        $inquiries = $query->latest()->paginate(10);

        return view('livewire.handler.attendance-inquiry.index', compact('inquiries'));
    }
}
