<?php

/** Goal: Handle Leave Request detailed review and processing for approvers, Livewire: Handler.LeaveRequest.ApprovalCenter.Show, Deps: LeaveRequest, LeaveRequestService */

namespace App\Livewire\Handler\LeaveRequest\ApprovalCenter;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\LeaveRequest\LeaveRequest;
use App\Services\LeaveRequest\LeaveRequestService;
use Livewire\Component;

class Show extends Component
{
    use HandlesErrors;

    public $requestId;

    public $note = '';

    public function mount($id)
    {
        $this->requestId = $id;
    }

    public function approve(LeaveRequestService $service)
    {
        $this->runSafely(function () use ($service) {
            $request = LeaveRequest::findOrFail($this->requestId);
            $service->processAction($request, 'approve', auth()->user(), $this->note);

            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Pengajuan telah disetujui.');

            return redirect()->route('leave-request.approval-center.index');
        });
    }

    public function reject(LeaveRequestService $service)
    {
        $this->validate([
            'note' => 'required|min:5',
        ], [
            'note.required' => 'Mohon berikan alasan penolakan.',
        ]);

        $this->runSafely(function () use ($service) {
            $request = LeaveRequest::findOrFail($this->requestId);
            $service->processAction($request, 'reject', auth()->user(), $this->note);

            $this->dispatch('swal', icon: 'info', title: 'Ditolak', text: 'Pengajuan telah ditolak.');

            return redirect()->route('leave-request.approval-center.index');
        });
    }

    public function render()
    {
        $user = auth()->user();
        $request = LeaveRequest::with(['user.pegawai.jabatanRelasi.divisionRelasi', 'user.pegawai.jabatanRelasi.placementRelasi', 'user.pegawai.jabatanRelasi.supervisor', 'leaveType', 'backupPerson', 'histories.actedByUser'])
            ->findOrFail($this->requestId);

        // Otoritas vaildasi
        $canApprove = false;
        if (in_array($request->status, ['pending_backup', 'pending_spv', 'pending_hrd', 'pending_management'])) {
            $canApprove = match ($request->status) {
                'pending_backup' => $request->backup_person_id === $user->id,
                'pending_spv' => ($request->user->pegawai->jabatanRelasi->supervisor_id ?? null) === $user->id,
                'pending_hrd' => $request->user->pegawai->jabatanRelasi->placementRelasi->hrds->contains('id', $user->id),
                'pending_management' => $request->user->pegawai->jabatanRelasi->placementRelasi->managements->contains('id', $user->id),
                default => false
            };
        }

        // Helper untuk label role approval di view
        $request->approval_role = match ($request->status) {
            'pending_backup' => 'Personel Backup',
            'pending_spv' => 'Atasan Langsung',
            'pending_hrd' => 'HRD Department',
            'pending_management' => 'Management',
            default => 'Selesai'
        };

        return view('livewire.handler.leave-request.approval-center.show', [
            'request' => $request,
            'canApprove' => $canApprove,
        ]);
    }
}
