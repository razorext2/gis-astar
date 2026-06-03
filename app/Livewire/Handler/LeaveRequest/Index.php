<?php
/** Goal: Display list of leave requests (own or all based on permission), Caller: resources/views/dashboard/leave-request/index.blade.php, Deps: User, LeaveRequest */

namespace App\Livewire\Handler\LeaveRequest;

use App\Models\LeaveRequest\LeaveRequest;
use App\Models\LeaveRequest\LeaveType;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    
    public $activeTab = 'own';

    #[Url(as: 'q')]
    public $search = '';

    #[Url(as: 'status')]
    public $filterStatus = '';

    #[Url(as: 'type')]
    public $filterLeaveType = '';

    public function mount()
    {
        // Default to all if user has view-all and requested from somewhere or just preference?
        // Keep 'own' as default for safety.
    }

    public function setTab($tab)
    {
        if ($tab === 'all' && !auth()->user()->can('leave-list-all')) {
            return;
        }

        $this->activeTab = $tab;
        $this->resetFilters();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterStatus', 'filterLeaveType']);
        $this->resetPage();
    }

    public function updated($property)
    {
        if (in_array($property, ['search', 'filterStatus', 'filterLeaveType'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $query = LeaveRequest::with(['leaveType', 'backupPerson', 'user.pegawai.jabatanRelasi']);

        if ($this->activeTab === 'own') {
            $query->where('user_id', auth()->id());
        } elseif ($this->activeTab === 'all' && auth()->user()->can('leave-list-all')) {
            // No user filter
        } else {
            $query->where('user_id', auth()->id());
        }

        // Apply Search
        $query->when($this->search, function ($q) {
            $q->where(function ($sub) {
                $sub->where('reason', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($qu) {
                        $qu->where('name', 'like', '%' . $this->search . '%')
                            ->orWhereHas('pegawai', function ($qp) {
                                $qp->where('kode_pegawai', 'like', '%' . $this->search . '%');
                            });
                    });
            });
        });

        // Apply Status Filter
        $query->when($this->filterStatus, function ($q) {
            $q->where('status', $this->filterStatus);
        });

        // Apply Leave Type Filter
        $query->when($this->filterLeaveType, function ($q) {
            $q->where('leave_type_id', $this->filterLeaveType);
        });

        $leaveRequests = $query->latest()->paginate(10);
        $leaveTypes = LeaveType::orderBy('name')->get();

        return view('livewire.handler.leave-request.index', compact('leaveRequests', 'leaveTypes'));
    }
}
