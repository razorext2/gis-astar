<?php

/** Goal: Menampilkan popup notifikasi approval cuti di dashboard, Caller: dashboard.blade.php / dashboard-user.blade.php, Deps: LeaveRequest */

namespace App\Livewire\Dashboard;

use App\Models\LeaveRequest\LeaveRequest;
use Illuminate\Support\Collection;
use Livewire\Component;

class LeaveApprovalPopup extends Component
{
    public bool $showPopup = false;

    public bool $hasPending = false;

    public int $currentIndex = 0;

    /**
     * Cache hasil query per request cycle agar tidak re-query berkali-kali.
     */
    private ?Collection $cachedRequests = null;

    public function mount(): void
    {
        $this->hasPending = $this->getPendingRequests()->isNotEmpty();
    }

    public function dismiss(): void
    {
        $this->showPopup = false;
    }

    public function next(): void
    {
        if ($this->currentIndex < $this->getPendingRequests()->count() - 1) {
            $this->currentIndex++;
        }
    }

    public function previous(): void
    {
        if ($this->currentIndex > 0) {
            $this->currentIndex--;
        }
    }

    public function render(): \Illuminate\View\View
    {
        $pendingRequests = $this->getPendingRequests();
        $total = $pendingRequests->count();

        // Pastikan index tidak melebihi batas jika data berkurang
        if ($this->currentIndex >= $total) {
            $this->currentIndex = max(0, $total - 1);
        }

        return view('livewire.dashboard.leave-approval-popup', [
            'currentRequest' => $pendingRequests->values()->get($this->currentIndex),
            'totalPending'   => $total,
            'currentIndex'   => $this->currentIndex,
        ]);
    }

    /**
     * Query semua leave request yang menunggu aksi dari user yang sedang login.
     * Menggunakan logika yang sama dengan ApprovalCenter\Index.
     *
     * Hasil di-cache per request cycle via $cachedRequests property.
     */
    private function getPendingRequests(): Collection
    {
        if ($this->cachedRequests !== null) {
            return $this->cachedRequests;
        }

        $user = auth()->user();

        $this->cachedRequests = LeaveRequest::with([
            'user.pegawai.jabatanRelasi.divisionRelasi',
            'leaveType',
        ])
            ->select(['id', 'user_id', 'leave_type_id', 'backup_person_id', 'start_date', 'end_date', 'total_days', 'reason', 'status', 'updated_at'])
            ->whereIn('status', ['pending_backup', 'pending_spv', 'pending_hrd', 'pending_management'])
            ->where(function ($q) use ($user) {
                // 1. Sebagai Backup Person
                $q->where(function ($sq) use ($user) {
                    $sq->where('status', 'pending_backup')->where('backup_person_id', $user->id);
                });

                // 2. Sebagai Atasan Langsung (Supervisor)
                $q->orWhere(function ($sq) use ($user) {
                    $sq->where('status', 'pending_spv')
                        ->whereHas('user.pegawai.jabatanRelasi.supervisors', fn ($jq) => $jq->where('users.id', $user->id));
                });

                // 3. Sebagai HRD di placement pemohon
                $q->orWhere(function ($sq) use ($user) {
                    $sq->where('status', 'pending_hrd')
                        ->whereHas('user.pegawai.jabatanRelasi.placementRelasi.hrds', fn ($jq) => $jq->where('users.id', $user->id));
                });

                // 4. Sebagai Management di placement pemohon
                $q->orWhere(function ($sq) use ($user) {
                    $sq->where('status', 'pending_management')
                        ->whereHas('user.pegawai.jabatanRelasi.placementRelasi.managements', fn ($jq) => $jq->where('users.id', $user->id));
                });
            })
            ->latest()
            ->get();

        return $this->cachedRequests;
    }
}
