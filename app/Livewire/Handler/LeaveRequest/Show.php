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

    public function summary()
    {
        $this->showSummary = true;
        $this->dispatch('show-pdf-modal', url: route('leave-request.pdf', $this->requestId).'?t='.now()->timestamp);
    }

    public function mount($id)
    {
        $this->requestId = $id;
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

        // C1: Guard — hanya pemilik, backup person, atau user dengan permission leave-list-all
        $user = auth()->user();
        $isOwner = $request->user_id === $user->id;
        $isBackup = $request->backup_person_id === $user->id;
        $canViewAll = $user->can('leave-list-all') || $user->can('leave-approval-center');

        if (! $isOwner && ! $isBackup && ! $canViewAll) {
            abort(403, 'Anda tidak memiliki akses untuk melihat pengajuan ini.');
        }

        return view('livewire.handler.leave-request.show', compact('request'));
    }
}
