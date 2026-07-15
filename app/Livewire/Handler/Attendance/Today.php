<?php

/** Goal: Display check-in and check-out records for a selected date, Caller: Dashboard, Deps: Attendance, AttendanceOut, Pegawai, User */

namespace App\Livewire\Handler\Attendance;

use App\Models\Attendance;
use App\Models\AttendanceOut;
use App\Services\Attendance\AttendanceService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy]
class Today extends Component
{
    use WithPagination;

    public Attendance|AttendanceOut|null $attendance = null;

    #[Url]
    public string $date;

    #[Url]
    public string $role = '';

    #[Url]
    public string $search = '';

    public string $address = '';

    public bool $showModal = false;

    public bool $isModalOut = false;

    public function mount(): void
    {
        $this->date = Carbon::now()->toDateString();
    }

    public function placeholder(): string
    {
        return '<x-skeleton.today />';
    }

    /**
     * Centralized role options based on user permissions.
     */
    #[Computed]
    public function roleOptions(): array
    {
        $user = auth()->user();
        $options = [];

        if ($user->can('sales-export-medan') || $user->can('attendance-approve')) {
            $options['Sales'] = 'Sales Medan';
        }

        if ($user->can('sales-export-agrotec') || $user->can('attendance-approve')) {
            $options['Sales-Agrotec'] = 'Sales Agrotec';
        }

        if ($user->can('sales-export-pku') || $user->can('attendance-approve')) {
            $options['Sales-PKU'] = 'Sales Pekanbaru';
        }

        if ($user->can('sales-export-jkt') || $user->can('attendance-approve')) {
            $options['Sales-JKT'] = 'Sales Jakarta';
        }

        if ($user->can('sales-export-idy') || $user->can('attendance-approve')) {
            $options['Sales-IDY'] = 'Sales Indodaya';
        }

        if ($user->can('sales-export-kurir-bank') || $user->can('attendance-approve')) {
            $options['Kurir-Bank'] = 'Kurir Bank';
        }

        if ($user->can('driver-list-jkt') || $user->can('driver-approve') || $user->can('attendance-approve')) {
            $options['Driver-Jkt'] = 'Driver Jakarta';
        }

        if ($user->can('driver-list-medan') || $user->can('driver-approve') || $user->can('attendance-approve')) {
            $options['Driver-Medan'] = 'Driver Medan';
        }

        if ($user->can('attendance-approve')) {
            $options['Employee'] = 'Karyawan';
        }

        if ($user->can('technician-approve') || $user->can('attendance-approve')) {
            $options['Teknisi'] = 'Teknisi';
        }

        if ($user->can('spk-list') || $user->can('attendance-approve')) {
            $options['Mekanik'] = 'Mekanik';
        }

        return $options;
    }

    public function openModal(int $id): void
    {
        if ($this->showModal && $this->attendance?->id == $id && ! $this->isModalOut) {
            $this->showModal = false;

            return;
        }

        $data = Attendance::with(['pegawaiRelasi', 'user'])->find($id);

        if (! $data) {
            return;
        }

        $this->attendance = $data;
        $this->isModalOut = false;
        $this->address = AttendanceService::fetchAddress($data->latitude, $data->longitude);
        $this->showModal = true;
        $this->dispatch('attendance-modal-ready');
    }

    public function openModalOut(int $id): void
    {
        if ($this->showModal && $this->attendance?->id == $id && $this->isModalOut) {
            $this->showModal = false;

            return;
        }

        $data = AttendanceOut::with(['pegawaiRelasi', 'user'])->find($id);

        if (! $data) {
            return;
        }

        $this->attendance = $data;
        $this->isModalOut = true;
        $this->address = AttendanceService::fetchAddress($data->latitude, $data->longitude);
        $this->showModal = true;
        $this->dispatch('attendance-modal-ready');
    }

    public function applyFilter(): void
    {
        $this->resetPage('pageIn');
        $this->resetPage('pageOut');
    }

    public function updatedSearch(): void
    {
        $this->resetPage('pageIn');
        $this->resetPage('pageOut');
    }

    /**
     * Build a base attendance query with role-based filtering applied.
     *
     * @param  class-string<Attendance|AttendanceOut>  $model
     */
    private function buildAttendanceQuery(string $model, string $dateColumn): Builder
    {
        $targetRoles = array_keys($this->roleOptions);

        return $model::with(['pegawaiRelasi', 'user.roles'])
            ->whereDate($dateColumn, $this->date)
            ->where('status', 1)
            ->when($this->search, fn ($q) => $q->whereHas('pegawaiRelasi', fn ($q) => $q->where('full_name', 'like', "%{$this->search}%")))
            ->when($this->role, fn ($q) => $q->whereHas('user.roles', fn ($q) => $q->where('name', $this->role)))
            ->when(! $this->role && ! empty($targetRoles), fn ($q) => $q->whereHas('user.roles', fn ($q) => $q->whereIn('name', $targetRoles)))
            ->latest('waktuori');
    }

    public function render(): View
    {
        $ins = $this->buildAttendanceQuery(Attendance::class, 'jam_masuk')->paginate(6, ['*'], 'pageIn');
        $outs = $this->buildAttendanceQuery(AttendanceOut::class, 'jam_keluar')->paginate(6, ['*'], 'pageOut');

        return view('livewire.handler.attendance.today', compact('ins', 'outs'));
    }
}
