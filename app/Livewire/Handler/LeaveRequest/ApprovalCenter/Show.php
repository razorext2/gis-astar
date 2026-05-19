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

    public bool $showSummary = false;

    public function summary()
    {
        $this->showSummary = true;
        $this->dispatch('show-pdf-modal', url: route('leave-request.pdf', $this->requestId).'?t='.now()->timestamp);
    }

    public function mount($id)
    {
        $this->requestId = $id;
    }

    /**
     * Cek apakah user saat ini berhak approve/reject request ini.
     */
    private function isAuthorizedApprover(LeaveRequest $request): bool
    {
        $user = auth()->user();

        return match ($request->status) {
            'pending_backup' => $request->backup_person_id === $user->id,
            'pending_spv' => ($request->user->pegawai->jabatanRelasi->supervisor_id ?? null) === $user->id,
            'pending_hrd' => (bool) $request->user->pegawai->jabatanRelasi->placementRelasi?->hrds->contains('id', $user->id),
            'pending_management' => (bool) $request->user->pegawai->jabatanRelasi->placementRelasi?->managements->contains('id', $user->id),
            default => false,
        };
    }

    public function approve(LeaveRequestService $service)
    {
        $this->runSafely(function () use ($service) {
            $request = LeaveRequest::findOrFail($this->requestId);

            // C2: Guard — pastikan user berhak approve
            if (! $this->isAuthorizedApprover($request)) {
                $this->dispatch('swal', icon: 'error', title: 'Akses Ditolak', text: 'Anda tidak memiliki otorisasi untuk menyetujui pengajuan ini.');

                return;
            }

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

            // C2: Guard — pastikan user berhak reject
            if (! $this->isAuthorizedApprover($request)) {
                $this->dispatch('swal', icon: 'error', title: 'Akses Ditolak', text: 'Anda tidak memiliki otorisasi untuk menolak pengajuan ini.');

                return;
            }

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

        // Otoritas validasi
        $canApprove = $this->isAuthorizedApprover($request);

        return view('livewire.handler.leave-request.approval-center.show', [
            'request' => $request,
            'canApprove' => $canApprove,
        ]);
    }
}
