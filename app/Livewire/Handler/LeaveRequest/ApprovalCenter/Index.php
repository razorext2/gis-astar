<?php
/** Goal: Handle Leave Request approval list for authorized users, Caller: resources/views/dashboard/leave-request/approval-center/index.blade.php, Deps: User, LeaveRequest */

namespace App\Livewire\Handler\LeaveRequest\ApprovalCenter;

use App\Models\LeaveRequest\LeaveRequest;
use App\Models\LeaveRequest\LeaveType;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $activeTab = 'pending';

    #[Url(as: 'q')]
    public $search = '';

    #[Url(as: 'status')]
    public $filterStatus = '';

    #[Url(as: 'type')]
    public $filterLeaveType = '';

    public function setTab($tab)
    {
        if ($tab === 'all' && !auth()->user()->can('leave-view-all')) {
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
        $user = auth()->user();
        
        $query = LeaveRequest::with(['user.pegawai.jabatanRelasi', 'leaveType']);

        if ($this->activeTab === 'pending') {
            $query->whereIn('status', ['pending_backup', 'pending_spv', 'pending_hrd', 'pending_management']);
            
            // Complex Role Filter
            $query->where(function($q) use ($user) {
                // 1. As Backup
                $q->where(function($sq) use ($user) {
                    $sq->where('status', 'pending_backup')->where('backup_person_id', $user->id);
                });

                // 2. As Supervisor (Check if applicant's supervisor is me)
                $q->orWhere(function($sq) use ($user) {
                    $sq->where('status', 'pending_spv')
                       ->whereHas('user.pegawai.jabatanRelasi', fn($jq) => $jq->where('supervisor_id', $user->id));
                });

                // 3. As HRD (User is assigned as HRD in applicant's placement)
                $q->orWhere(function($sq) use ($user) {
                    $sq->where('status', 'pending_hrd')
                       ->whereHas('user.pegawai.jabatanRelasi.placementRelasi.hrds', fn($jq) => $jq->where('users.id', $user->id));
                });

                // 4. As Management (User is assigned as Management in applicant's placement)
                $q->orWhere(function($sq) use ($user) {
                    $sq->where('status', 'pending_management')
                       ->whereHas('user.pegawai.jabatanRelasi.placementRelasi.managements', fn($jq) => $jq->where('users.id', $user->id));
                });
            });
        } else {
            // Tab ALL - No default role-based status filter if they have leave-view-all
            if (!$user->can('leave-view-all')) {
                // Fallback to what they can see if somehow accessed
                $query->where('user_id', $user->id);
            }
        }

        // Search
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

        // Filters
        $query->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus));
        $query->when($this->filterLeaveType, fn($q) => $q->where('leave_type_id', $this->filterLeaveType));

        $pendingApprovals = $query->latest()->paginate(10);
        $leaveTypes = LeaveType::orderBy('name')->get();

        // Helper untuk label role approval
        foreach($pendingApprovals as $request) {
            $request->approval_role = match($request->status) {
                'pending_backup' => 'Personel Backup',
                'pending_spv' => 'Atasan Langsung',
                'pending_hrd' => 'HRD Department',
                'pending_management' => 'Management',
                default => ''
            };
        }

        return view('livewire.handler.leave-request.approval-center.index', compact('pendingApprovals', 'leaveTypes'));
    }
}
