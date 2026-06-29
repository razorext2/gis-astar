<?php

namespace App\Livewire\Handler\LeaveRequest;

/** Goal: Handle Leave Request detail view, Caller: resources/views/dashboard/leave-request/show.blade.php, Deps: User, LeaveRequest */

use App\Livewire\Concerns\HandlesErrors;
use App\Models\LeaveRequest\LeaveRequest;
use Livewire\Component;

class Show extends Component
{
    use HandlesErrors;

    public $requestId;

    public bool $showSummary = false;

    public string $cancelReason = '';

    public function summary()
    {
        $this->showSummary = true;
        $this->dispatch('show-pdf-modal', url: route('leave-request.pdf', $this->requestId).'?t='.now()->timestamp);
    }

    public function mount($id)
    {
        $this->requestId = is_object($id) ? $id->id : $id;
    }

    public function cancelRequest(\App\Services\LeaveRequest\LeaveRequestService $service)
    {
        $this->runSafely(function () use ($service) {
            $request = LeaveRequest::findOrFail($this->requestId);

            // Security check: Only owner
            if ($request->user_id !== auth()->id()) {
                $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'Anda tidak memiliki akses untuk membatalkan pengajuan ini.');

                return;
            }

            // Logical check: Only if pending_backup
            if ($request->status !== 'pending_backup') {
                $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'Pengajuan hanya dapat dibatalkan jika belum disetujui oleh Personel Backup.');

                return;
            }

            $service->processAction($request, 'cancel', auth()->user(), 'Dibatalkan oleh pemohon');

            session()->flash('success', 'Pengajuan cuti berhasil dibatalkan.');

            return redirect()->route('leave-request.my-requests.index');
        });
    }

    public function requestCancellation(\App\Services\LeaveRequest\LeaveRequestService $service)
    {
        $this->validate([
            'cancelReason' => 'required|min:5',
        ], [
            'cancelReason.required' => 'Mohon berikan alasan pembatalan.',
            'cancelReason.min' => 'Alasan pembatalan minimal 5 karakter.',
        ]);

        $this->runSafely(function () use ($service) {
            $request = LeaveRequest::findOrFail($this->requestId);

            // Security check: Only owner
            if ($request->user_id !== auth()->id()) {
                $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'Anda tidak memiliki akses untuk membatalkan pengajuan ini.');
                return;
            }

            $service->requestCancel($request, auth()->user(), $this->cancelReason);

            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Permintaan pembatalan cuti telah diajukan ke HRD.');
            $this->reset('cancelReason');
            $this->dispatch('close-modal', 'cancel-request-modal');
        });
    }

    public function render()
    {
        $request = LeaveRequest::with([
            'user.pegawai.jabatanRelasi.divisionRelasi',
            'user.pegawai.jabatanRelasi.placementRelasi',
            'user.pegawai.jabatanRelasi.supervisors',
            'leaveType',
            'backupPerson',
            'histories.actedByUser',
        ])->findOrFail($this->requestId);

        // Guard using standard policy
        if (! auth()->user()->can('view', $request)) {
            abort(403, 'Anda tidak memiliki akses untuk melihat pengajuan ini.');
        }

        return view('livewire.handler.leave-request.show', compact('request'));
    }
}
