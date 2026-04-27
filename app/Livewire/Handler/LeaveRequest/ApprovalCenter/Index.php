<?php
/** Goal: Handle Leave Request approval list for authorized users, Caller: resources/views/dashboard/leave-request/approval-center/index.blade.php, Deps: User, LeaveRequest */

namespace App\Livewire\Handler\LeaveRequest\ApprovalCenter;

use App\Models\LeaveRequest\LeaveRequest;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $user = auth()->user();
        
        $query = LeaveRequest::with(['user.pegawai', 'leaveType'])
            ->whereIn('status', ['pending_backup', 'pending_spv', 'pending_hrd', 'pending_management']);

        // Filter logic based on role/auth
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

            // 3. As HRD
            if ($user->hasRole('HRD')) {
                $q->orWhere('status', 'pending_hrd');
            }

            // 4. As Management
            if ($user->hasRole('Management')) {
                $q->orWhere('status', 'pending_management');
            }
        });

        $pendingApprovals = $query->latest()->get();

        // Helper untuk label role approval di view
        foreach($pendingApprovals as $request) {
            $request->approval_role = match($request->status) {
                'pending_backup' => 'Personel Backup',
                'pending_spv' => 'Atasan Langsung',
                'pending_hrd' => 'HRD Department',
                'pending_management' => 'Management',
                default => ''
            };
        }

        return view('livewire.handler.leave-request.approval-center.index', compact('pendingApprovals'));
    }
}
