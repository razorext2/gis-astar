<?php

/** Goal: Handle Leave Request detailed review and processing for approvers, Livewire: Handler.LeaveRequest.ApprovalCenter.Show, Deps: LeaveRequest, LeaveRequestService, LeaveRequestPolicy */

namespace App\Livewire\Handler\LeaveRequest\ApprovalCenter;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\LeaveRequest\LeaveRequest;
use App\Services\LeaveRequest\LeaveRequestService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Show extends Component
{
    use AuthorizesRequests, HandlesErrors;

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
        $this->requestId = is_object($id) ? $id->id : $id;
    }

    public function approve(LeaveRequestService $service): void
    {
        $this->runSafely(function () use ($service) {
            $request = LeaveRequest::with([
                'user.pegawai.jabatanRelasi.supervisors',
                'user.pegawai.jabatanRelasi.placementRelasi.hrds',
                'user.pegawai.jabatanRelasi.placementRelasi.managements',
            ])->findOrFail($this->requestId);

            $this->authorize('approve', $request);

            $service->processAction($request, 'approve', auth()->user(), $this->note);

            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Pengajuan telah disetujui.');

            return redirect()->route($this->resolveRedirectRoute());
        });
    }

    public function reject(LeaveRequestService $service): void
    {
        $this->validate([
            'note' => 'required|min:5',
        ], [
            'note.required' => 'Mohon berikan alasan penolakan.',
        ]);

        $this->runSafely(function () use ($service) {
            $request = LeaveRequest::with([
                'user.pegawai.jabatanRelasi.supervisors',
                'user.pegawai.jabatanRelasi.placementRelasi.hrds',
                'user.pegawai.jabatanRelasi.placementRelasi.managements',
            ])->findOrFail($this->requestId);

            $this->authorize('approve', $request);

            $service->processAction($request, 'reject', auth()->user(), $this->note);

            $this->dispatch('swal', icon: 'info', title: 'Ditolak', text: 'Pengajuan telah ditolak.');

            return redirect()->route($this->resolveRedirectRoute());
        });
    }

    /**
     * Resolve redirect route based on user permissions.
     * Users without approval-center access are sent to dashboard.
     */
    private function resolveRedirectRoute(): string
    {
        return auth()->user()->hasAnyPermission(['leave-approval-center', 'leave-list-all'])
            ? 'leave-request.approval-center.index'
            : 'dashboard';
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        $request = LeaveRequest::with([
            'user.pegawai.jabatanRelasi.divisionRelasi',
            'user.pegawai.jabatanRelasi.placementRelasi.hrds',
            'user.pegawai.jabatanRelasi.placementRelasi.managements',
            'user.pegawai.jabatanRelasi.supervisors',
            'leaveType',
            'backupPerson',
            'histories.actedByUser',
        ])->findOrFail($this->requestId);

        $this->authorize('view', $request);

        // Cek apakah user berhak approve pada tahap ini
        $canApprove = auth()->user()->can('approve', $request);

        return view('livewire.handler.leave-request.approval-center.show', [
            'request' => $request,
            'canApprove' => $canApprove,
        ]);
    }
}
