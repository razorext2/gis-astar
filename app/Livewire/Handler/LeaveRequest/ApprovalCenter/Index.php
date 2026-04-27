<?php

namespace App\Livewire\Handler\LeaveRequest\ApprovalCenter;

/** Goal: Handle Leave Request approval list for authorized users, Caller: resources/views/dashboard/leave-request/approval-center/index.blade.php, Deps: User, LeaveRequest */

use App\Livewire\Concerns\HandlesErrors;
use Livewire\Component;

class Index extends Component
{
    use HandlesErrors;

    public function render()
    {
        // Data dummy untuk perancangan UI Approval Center
        $pendingApprovals = collect([
            (object) [
                'id' => 101,
                'user' => (object) ['name' => 'Budi Santoso', 'pegawai' => (object) ['kode_pegawai' => 'PEG-001']],
                'leave_type' => (object) ['name' => 'Cuti Tahunan'],
                'start_date' => now()->addDays(5),
                'end_date' => now()->addDays(7),
                'total_days' => 3,
                'status' => 'pending_spv',
                'approval_role' => 'Atasan Langsung',
                'reason' => 'Ada keperluan keluarga mendesak di kampung halaman.',
                'created_at' => now()->subHours(2),
            ],
            (object) [
                'id' => 102,
                'user' => (object) ['name' => 'Siti Aminah', 'pegawai' => (object) ['kode_pegawai' => 'PEG-042']],
                'leave_type' => (object) ['name' => 'Izin Sakit'],
                'start_date' => now(),
                'end_date' => now()->addDay(),
                'total_days' => 2,
                'status' => 'pending_hrd',
                'approval_role' => 'HRD',
                'reason' => 'Mengalami gejala flu berat dan butuh istirahat total.',
                'created_at' => now()->subHours(5),
            ],
            (object) [
                'id' => 103,
                'user' => (object) ['name' => 'Andi Wijaya', 'pegawai' => (object) ['kode_pegawai' => 'PEG-012']],
                'leave_type' => (object) ['name' => 'Cuti Menikah'],
                'start_date' => now()->addDays(14),
                'end_date' => now()->addDays(16),
                'total_days' => 3,
                'status' => 'pending_management',
                'approval_role' => 'Manajemen',
                'reason' => 'Melaksanakan prosesi pernikahan di Yogyakarta.',
                'created_at' => now()->subDay(),
            ],
        ]);

        return view('livewire.handler.leave-request.approval-center.index', compact('pendingApprovals'));
    }
}
