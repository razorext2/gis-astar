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
    public string $type = 'in'; // 'in' or 'out'

    public function verify(int $id): void
    {
        if (!auth()->user()?->can('attendance-approve')) {
            $this->dispatch('swal', title: 'Ditolak', text: 'Anda tidak memiliki akses.', icon: 'error');
            return;
        }

        try {
            $modelClass = $this->type === 'in' ? Attendance::class : AttendanceOut::class;
            $tableName = $this->type === 'in' ? 'AttendanceInTable' : 'AttendanceOutTable';

            $updated = $modelClass::query()->where('id', $id)->update([
                'verified' => 1,
                'verified_by' => auth()->id(),
                'status' => 1,
            ]);

            if ($updated) {
                $this->dispatch('swal', title: 'Berhasil', text: 'Absensi berhasil di verifikasi', icon: 'success');
                $this->dispatch("pg:eventRefresh-{$tableName}");
            }
        } catch (\Exception $e) {
            Log::error($e);
            $this->dispatch('swal', title: 'Gagal', text: 'Terjadi kesalahan sistem.', icon: 'error');
        }
    }

    public function reject(int $id): void
    {
        if (!auth()->user()?->can('attendance-approve')) {
            $this->dispatch('swal', title: 'Ditolak', text: 'Anda tidak memiliki akses.', icon: 'error');
            return;
        }

        try {
            $modelClass = $this->type === 'in' ? Attendance::class : AttendanceOut::class;
            $tableName = $this->type === 'in' ? 'AttendanceInTable' : 'AttendanceOutTable';

            $updated = $modelClass::query()->where('id', $id)->update([
                'verified' => 0,
                'verified_by' => auth()->id(),
                'status' => 2, // Rejected
            ]);

            if ($updated) {
                $this->dispatch('swal', title: 'Berhasil', text: 'Absensi berhasil ditolak', icon: 'success');
                $this->dispatch("pg:eventRefresh-{$tableName}");
            }
        } catch (\Exception $e) {
            Log::error($e);
            $this->dispatch('swal', title: 'Gagal', text: 'Terjadi kesalahan sistem.', icon: 'error');
        }
    }

    public function render(): View
    {
        $modelClass = $this->type === 'in' ? Attendance::class : AttendanceOut::class;
        
        $records = $modelClass::query()
            ->notVerified()
            ->with(['pegawaiRelasi'])
            ->latest('waktuori')
            ->get();

        return view('livewire.components.unverified-attendance', compact('records'));
    }
}
