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
            'user.pegawai.jabatanRelasi.supervisor',
            'leaveType',
            'backupPerson',
            'histories.actedByUser',
        ])->findOrFail($this->requestId);

        return view('livewire.handler.leave-request.show', compact('request'));
    }
}
