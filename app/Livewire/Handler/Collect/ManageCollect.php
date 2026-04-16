<?php

namespace App\Livewire\Handler\Collect;

use App\Models\CollectIdyPpn;
use App\Models\Collector;
use App\Models\CollectTask;
use App\Models\CollectTaskPpn;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class ManageCollect extends Component
{
    public $showRescheduleModal = false;

    public $showChangeCollectorModal = false;

    public $id;

    public $collectData;

    // Reschedule fields
    public $new_assign_date;

    // Change collector fields
    public $search_collector = '';

    public $new_kode_pegawai;

    public $selected_collector_name = '';

    public $collectors = [];

    #[On('reschedule')]
    public function openReschedule($id)
    {
        $this->checkPermission();

        $this->id = $id;
        $this->collectData = Collector::with('pegawaiRelasi')->findOrFail($id);
        $this->new_assign_date = $this->collectData->assign_date;
        $this->search_collector = '';
        $this->showRescheduleModal = true;
    }

    #[On('changeCollector')]
    public function openChangeCollector($id)
    {
        $this->checkPermission();

        $this->id = $id;
        $this->collectData = Collector::with('pegawaiRelasi')->findOrFail($id);
        $this->new_kode_pegawai = $this->collectData->kode_pegawai;
        $this->selected_collector_name = $this->collectData->pegawaiRelasi?->full_name ?? 'N/A';
        $this->search_collector = '';
        $this->collectors = [];
        $this->showChangeCollectorModal = true;
    }

    public function updatedSearchCollector($value)
    {
        if (strlen($value) >= 2) {
            $this->collectors = Pegawai::select('kode_pegawai', 'full_name')
                ->where(function ($q) use ($value) {
                    $q->where('full_name', 'LIKE', "%{$value}%")
                        ->orWhere('kode_pegawai', 'LIKE', "%{$value}%");
                })
                ->whereHas('userRelasi', function ($user) {
                    $user->where('is_active', 1)
                        ->whereHas('roles', function ($role) {
                            $role->where('name', 'Collector');
                        });
                })
                ->orderBy('full_name')
                ->limit(10)
                ->get()
                ->toArray();
        } else {
            $this->collectors = [];
        }
    }

    public function selectCollector($kode_pegawai, $full_name)
    {
        $this->new_kode_pegawai = $kode_pegawai;
        $this->selected_collector_name = $full_name;
        $this->search_collector = $full_name;
        $this->collectors = [];
    }

    private function getMasterTaskQuery($collect)
    {
        return match ($collect->bill_type) {
            'idcnonppn' => CollectTask::where('no_sr', $collect->no_sr),
            'idcppn' => CollectTaskPpn::where('tax_invoice', $collect->no_sr),
            'idyppn' => CollectIdyPpn::where('tax_invoice', $collect->no_sr),
            default => null,
        };
    }

    public function confirmReschedule()
    {
        $this->checkPermission();

        $this->validate([
            'new_assign_date' => 'required|date',
        ], [
            'new_assign_date.required' => 'Tanggal reschedule harus diisi.',
            'new_assign_date.date' => 'Format tanggal tidak valid.',
        ]);

        $query = Collector::findOrFail($this->id);

        try {
            DB::beginTransaction();

            $query->update([
                'assign_date' => $this->new_assign_date,
            ]);

            // Update master task
            $masterTask = $this->getMasterTaskQuery($query);
            if ($masterTask) {
                $masterTask->update(['assign_date' => $this->new_assign_date]);
            }

            DB::commit();

            $this->resetModals();
            $this->dispatch('swal', title: 'Berhasil', text: 'Jadwal kolektor berhasil diubah.', icon: 'success');
            $this->dispatch('redirectRoute', route('collect.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('swal', title: 'Gagal', text: 'Terjadi kesalahan: '.$e->getMessage(), icon: 'error');
        }
    }

    public function confirmChangeCollector()
    {
        $this->checkPermission();

        $this->validate([
            'new_kode_pegawai' => 'required|exists:tb_pegawai,kode_pegawai',
        ], [
            'new_kode_pegawai.required' => 'Kolektor harus dipilih.',
            'new_kode_pegawai.exists' => 'Kolektor tidak ditemukan di database.',
        ]);

        $query = Collector::findOrFail($this->id);

        try {
            DB::beginTransaction();

            $query->update([
                'kode_pegawai' => $this->new_kode_pegawai,
            ]);

            // Update master task
            $masterTask = $this->getMasterTaskQuery($query);
            if ($masterTask) {
                $masterTask->update(['assign_to' => $this->new_kode_pegawai]);
            }

            DB::commit();

            $this->resetModals();
            $this->dispatch('swal', title: 'Berhasil', text: 'Kolektor berhasil diganti.', icon: 'success');
            $this->dispatch('redirectRoute', route('collect.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('swal', title: 'Gagal', text: 'Terjadi kesalahan: '.$e->getMessage(), icon: 'error');
        }
    }

    public function resetModals()
    {
        $this->showRescheduleModal = false;
        $this->showChangeCollectorModal = false;
        $this->id = null;
        $this->collectData = null;
        $this->new_assign_date = null;
        $this->new_kode_pegawai = null;
        $this->selected_collector_name = '';
        $this->search_collector = '';
        $this->collectors = [];
    }

    public function checkPermission()
    {
        if (Auth::user()->cannot('collect-approve')) {
            return abort(403, 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }
    }

    public function render()
    {
        return view('livewire.handler.collect.manage-collect');
    }
}
