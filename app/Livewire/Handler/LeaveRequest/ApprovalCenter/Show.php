<?php

namespace App\Livewire\Handler\LeaveRequest\ApprovalCenter;

/** Goal: Handle Leave Request detailed review and processing for approvers, Livewire: Handler.LeaveRequest.ApprovalCenter.Show, Deps: LeaveRequest, LeaveRequestService */

use App\Livewire\Concerns\HandlesErrors;
use App\Models\LeaveRequest\LeaveRequest;
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

    public function approve()
    {
        // Logic will be integrated with LeaveRequestService later
        session()->flash('success', 'Pengajuan berhasil disetujui.');
        return redirect()->route('leave-request.approval-center.index');
    }

    public function reject()
    {
        $this->validate([
            'note' => 'required|min:5',
        ], [
            'note.required' => 'Mohon berikan alasan penolakan.',
        ]);

        // Logic will be integrated with LeaveRequestService later
        session()->flash('info', 'Pengajuan telah ditolak.');
        return redirect()->route('leave-request.approval-center.index');
    }

    public function render()
    {
        // Dummy data Detail untuk perancangan UI
        // Nanti diganti dengan query real: LeaveRequest::with(['user', 'leave_type', 'backup_person', 'histories.user'])->find($this->requestId);
        $request = (object)[
            'id' => $this->requestId,
            'user' => (object)[
                'name' => 'Muhammad Abdi Mayu', 
                'kode_pegawai' => 'PEG-001', 
                'profile_pic' => null,
                'jabatan' => (object)['name' => 'Senior Developer'],
                'division' => (object)['name' => 'IT Department']
            ],
            'leave_type' => (object)['name' => 'Cuti Tahunan'],
            'backup_person' => (object)['name' => 'Budi Santoso'],
            'start_date' => \Carbon\Carbon::parse('2026-04-25'),
            'end_date' => \Carbon\Carbon::parse('2026-04-27'),
            'total_days' => 3,
            'status' => 'pending_spv',
            'approval_role' => 'Atasan Langsung (SPV)',
            'reason' => 'Urusan keluarga di luar kota untuk menghadiri acara pernikahan kerabat dekat. Saya akan tetap standby via WhatsApp jika ada keadaan darurat.',
            'created_at' => now()->subDays(1),
            'histories' => collect([
                (object)[
                    'status' => 'pending_backup',
                    'description' => 'Pengajuan dibuat oleh Pemohon',
                    'acted_by_user' => (object)['name' => 'Muhammad Abdi Mayu'],
                    'created_at' => now()->subDays(1)->subHours(2),
                    'note' => null
                ],
                (object)[
                    'status' => 'pending_spv',
                    'description' => 'Disetujui oleh Backup Person',
                    'acted_by_user' => (object)['name' => 'Budi Santoso'],
                    'created_at' => now()->subDays(1)->subHours(1),
                    'note' => 'Siap membackup tugas harian.'
                ],
            ])
        ];

        return view('livewire.handler.leave-request.approval-center.show', compact('request'));
    }
}
