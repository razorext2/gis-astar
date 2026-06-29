<?php

/** Goal: Display list of all attendance inquiries for approval, Caller: resources/views/dashboard/attendance-inquiry/approval-center/index.blade.php, Deps: AttendanceInquiry */

namespace App\Livewire\Handler\AttendanceInquiry;

use App\Models\AttendanceInquiry\AttendanceInquiry;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ApprovalCenterIndex extends Component
{
    use WithPagination;

    public $activeTab = 'pending';

    #[Url(as: 'q')]
    public $search = '';

    #[Url(as: 'type')]
    public $filterType = '';

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'filterType']);
        $this->resetPage();
    }

    public function updated($property): void
    {
        if (in_array($property, ['search', 'filterType'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $query = AttendanceInquiry::with(['user.pegawai']);

        // Tab Filter
        if ($this->activeTab === 'pending') {
            $query->where('status', 'pending');
        } elseif ($this->activeTab === 'approved') {
            $query->where('status', 'approved');
        } elseif ($this->activeTab === 'rejected') {
            $query->where('status', 'rejected');
        }

        // Apply Search (employee name or employee code)
        $query->when($this->search, function ($q) {
            $q->where(function ($sub) {
                $sub->where('keterangan', 'like', '%'.$this->search.'%')
                    ->orWhere('kode_pegawai', 'like', '%'.$this->search.'%')
                    ->orWhereHas('user', function ($qu) {
                        $qu->where('name', 'like', '%'.$this->search.'%');
                    });
            });
        });

        // Apply Type Filter
        $query->when($this->filterType, function ($q) {
            $q->where('type_absen', $this->filterType);
        });

        $inquiries = $query->latest()->paginate(10);

        return view('livewire.handler.attendance-inquiry.approval-center.index', compact('inquiries'));
    }
}
