<?php

namespace App\Livewire\Handler\LeaveRequest;

/** Goal: Handle Leave Request detail view, Caller: resources/views/dashboard/leave-request/show.blade.php, Deps: User, LeaveRequest */

use App\Livewire\Concerns\HandlesErrors;
use Livewire\Component;

class Show extends Component
{
    use HandlesErrors;

    public $requestId;

    public function mount($id)
    {
        $this->requestId = $id;
    }

    public function render()
    {
        // Dummy data Detail untuk perancangan UI
        $request = (object)[
            'id' => $this->requestId,
            'user' => (object)['name' => 'Muhammad Abdi Mayu', 'kode_pegawai' => 'PEG-001', 'profile_pic' => null],
            'leave_type' => (object)['name' => 'Cuti Tahunan'],
            'backup_person' => (object)['name' => 'Budi Santoso'],
            'start_date' => \Carbon\Carbon::parse('2026-04-25'),
            'end_date' => \Carbon\Carbon::parse('2026-04-27'),
            'total_days' => 3,
            'status' => 'pending_spv',
            'reason' => 'Urusan keluarga di luar kota untuk menghadiri acara pernikahan kerabat dekat.',
            'created_at' => now()->subDays(1),
            'histories' => collect([
                (object)[
                    'status' => 'pending_backup',
                    'description' => 'Pengajuan dibuat oleh Pemohon',
                    'acted_by_user' => (object)['name' => 'Muhammad Abdi Mayu'],
                    'created_at' => now()->subDays(1)->subHours(2),
                ],
                (object)[
                    'status' => 'pending_spv',
                    'description' => 'Disetujui oleh Backup Person',
                    'acted_by_user' => (object)['name' => 'Budi Santoso'],
                    'created_at' => now()->subDays(1)->subHours(1),
                ],
            ])
        ];

        return view('livewire.handler.leave-request.show', compact('request'));
    }
}
