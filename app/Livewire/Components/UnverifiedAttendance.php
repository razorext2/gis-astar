<?php

/** Goal: Display and verify unverified attendance records, Caller: Blade views, Deps: Attendance, AttendanceOut */

namespace App\Livewire\Components;

use App\Models\Attendance;
use App\Models\AttendanceOut;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Component;

class UnverifiedAttendance extends Component
{
    /** @var string 'in'|'out' */
    public string $type = 'in';

    public int $perPage = 10;

    public int $totalCount = 0;

    private function getModelClass(): string
    {
        return match($this->type) {
            'out'   => AttendanceOut::class,
            default => Attendance::class,
        };
    }

    private function getTableName(): string
    {
        return match($this->type) {
            'out'   => 'AttendanceOutTable',
            default => 'AttendanceInTable',
        };
    }

    private function ensureCanApprove(): bool
    {
        if (!auth()->user()?->can('attendance-approve')) {
            $this->dispatch('swal', title: 'Ditolak', text: 'Anda tidak memiliki akses.', icon: 'error');

            return false;
        }

        return true;
    }

    public function loadMore(): void
    {
        $this->perPage += 10;
    }

    public function verify(int $id): void
    {
        if (!$this->ensureCanApprove()) {
            return;
        }

        try {
            $modelClass = $this->getModelClass();
            $updated = $modelClass::query()->where('id', $id)->update([
                'verified'    => 1,
                'verified_by' => auth()->id(),
                'status'      => 1,
            ]);

            if ($updated) {
                $this->dispatch('swal', title: 'Berhasil', text: 'Absensi berhasil di verifikasi', icon: 'success');
                $this->dispatch("pg:eventRefresh-{$this->getTableName()}");
            }
        } catch (\Exception $e) {
            Log::error($e);
            $this->dispatch('swal', title: 'Gagal', text: 'Terjadi kesalahan sistem.', icon: 'error');
        }
    }

    public function reject(int $id): void
    {
        if (!$this->ensureCanApprove()) {
            return;
        }

        try {
            $modelClass = $this->getModelClass();
            $updated = $modelClass::query()->where('id', $id)->update([
                'verified'    => 0,
                'verified_by' => auth()->id(),
                'status'      => 2,
            ]);

            if ($updated) {
                $this->dispatch('swal', title: 'Berhasil', text: 'Absensi berhasil ditolak', icon: 'success');
                $this->dispatch("pg:eventRefresh-{$this->getTableName()}");
            }
        } catch (\Exception $e) {
            Log::error($e);
            $this->dispatch('swal', title: 'Gagal', text: 'Terjadi kesalahan sistem.', icon: 'error');
        }
    }

    public function render(): View
    {
        $modelClass = $this->getModelClass();

        $this->totalCount = $modelClass::query()->notVerified()->count();

        $records = $modelClass::query()
            ->notVerified()
            ->with(['pegawaiRelasi'])
            ->latest('waktuori')
            ->limit($this->perPage)
            ->get();

        return view('livewire.components.unverified-attendance', compact('records'));
    }
}
