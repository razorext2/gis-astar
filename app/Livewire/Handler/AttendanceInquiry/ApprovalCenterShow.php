<?php

/** Goal: Handle HRD/Management approval/rejection actions on inquiry, Caller: resources/views/dashboard/attendance-inquiry/approval-center/show.blade.php, Deps: AttendanceInquiry, Attendance, AttendanceOut, SyncAttendanceToExternalServerJob, AttendanceService, HandlesErrors */

namespace App\Livewire\Handler\AttendanceInquiry;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Attendance;
use App\Models\AttendanceOut;
use App\Models\AttendanceInquiry\AttendanceInquiry;
use App\Services\Attendance\AttendanceService;
use App\Jobs\SyncAttendanceToExternalServerJob;
use Illuminate\Support\Collection;
use Livewire\Component;

class ApprovalCenterShow extends Component
{
    use HandlesErrors;

    public AttendanceInquiry $inquiry;

    public $rejection_reason;

    public Collection $allowedHrds;

    public function mount(AttendanceInquiry $inquiry): void
    {
        $inquiry->load(['user.pegawai.jabatanRelasi.placementRelasi.hrds']);

        $this->inquiry = $inquiry;
        $this->allowedHrds = $inquiry->user
            ?->pegawai
            ?->jabatanRelasi
            ?->placementRelasi
            ?->hrds
            ?? collect();
    }

    public function approve(): mixed
    {
        $this->authorize('approve', $this->inquiry);

        return $this->runSafely(function () {
            \Illuminate\Support\Facades\DB::transaction(function () {
                $photo = !empty($this->inquiry->bukti) ? $this->inquiry->bukti[0] : null;

                // 1. Insert into target table
                if ($this->inquiry->type_absen === 'in') {
                    Attendance::create([
                        'kode_pegawai' => $this->inquiry->kode_pegawai,
                        'upl' => 0,
                        'upl68' => 0,
                        'uplm68' => 0,
                        'upljam' => 0,
                        'jenis' => 'Inquiry',
                        'waktuori' => $this->inquiry->waktu_absen,
                        'timezone' => 'Asia/Jakarta',
                        'status' => 1,
                        'jam_masuk' => $this->inquiry->waktu_absen,
                        'longitude' => $this->inquiry->longitude,
                        'latitude' => $this->inquiry->latitude,
                        'position_status' => $this->inquiry->position_status,
                        'photoURL' => $photo,
                        'keterangan' => $this->inquiry->keterangan,
                        'verified' => 1,
                        'verified_by' => auth()->user()->name,
                        'distance' => 0,
                    ]);
                } else {
                    AttendanceOut::create([
                        'kode_pegawai' => $this->inquiry->kode_pegawai,
                        'upl' => 0,
                        'upl68' => 0,
                        'uplm68' => 0,
                        'upljam' => 0,
                        'jenis' => 'Inquiry',
                        'waktuori' => $this->inquiry->waktu_absen,
                        'timezone' => 'Asia/Jakarta',
                        'status' => 1,
                        'jam_keluar' => $this->inquiry->waktu_absen,
                        'longitude' => $this->inquiry->longitude,
                        'latitude' => $this->inquiry->latitude,
                        'position_status' => $this->inquiry->position_status,
                        'photoURL' => $photo,
                        'keterangan' => $this->inquiry->keterangan,
                        'verified' => 1,
                        'verified_by' => auth()->user()->name,
                        'distance' => 0,
                    ]);
                }

                // 2. Update inquiry status
                $this->inquiry->update([
                    'status' => 'approved',
                    'acted_by' => auth()->id(),
                    'acted_at' => now(),
                ]);

                // 3. Dispatch Job to sync to BSI
                $employeeUser = $this->inquiry->user;
                if ($employeeUser) {
                    SyncAttendanceToExternalServerJob::dispatch(
                        $employeeUser->id,
                        $this->inquiry->kode_pegawai,
                        $this->inquiry->waktu_absen->format('Y-m-d H:i:s'),
                        $this->inquiry->no_vt,
                        $this->inquiry->keterangan,
                        AttendanceService::isInMedan($this->inquiry->latitude, $this->inquiry->longitude) ? 'MEDAN' : 'NON MEDAN'
                    );
                }
            });

            $this->dispatch('swal', icon: 'success', title: 'Disetujui', text: 'Pengajuan laporan absensi berhasil disetujui dan disinkronkan.');

            return redirect()->route('attendance-inquiry.approval-center.index');
        }, 'Gagal menyetujui pengajuan laporan absensi.');
    }

    public function reject(): mixed
    {
        $this->authorize('approve', $this->inquiry);

        $this->validate([
            'rejection_reason' => 'required|string|min:5',
        ]);

        return $this->runSafely(function () {
            $this->inquiry->update([
                'status' => 'rejected',
                'rejection_reason' => $this->rejection_reason,
                'acted_by' => auth()->id(),
                'acted_at' => now(),
            ]);

            $this->dispatch('swal', icon: 'success', title: 'Ditolak', text: 'Pengajuan laporan absensi telah ditolak.');

            return redirect()->route('attendance-inquiry.approval-center.index');
        }, 'Gagal menolak pengajuan laporan absensi.');
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.handler.attendance-inquiry.approval-center.show', [
            'allowedHrds' => $this->allowedHrds,
        ]);
    }
}
