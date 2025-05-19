<?php

namespace App\Livewire\Handler\Point\Technician;

use App\Models\TechnicianPoints;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public $kodepegawai;
    #[Url]
    public $name;
    #[Url]
    public $is_redeemed;
    #[Url]
    public $no_vt;
    #[Url]
    public $from_date;
    #[Url]
    public $to_date;

    public function countRedeemedPoint()
    {
        return TechnicianPoints::where('is_redeemed', 1)->sum('point');
    }

    public function countNotRedeemedPoint()
    {
        return TechnicianPoints::where('is_redeemed', 0)->sum('point');
    }

    public function getData()
    {
        return TechnicianPoints::with('pegawai')
            ->when(!auth()->user()->can('technician-approve'), function ($query) {
                $query->where('kode_pegawai', auth()->user()->kode_pegawai);
            })
            ->when($this->kodepegawai, function ($query) {
                $query->where('kode_pegawai', 'like', "%{$this->kodepegawai}%");
            })
            ->when($this->name, function ($query) {
                $query->whereHas('pegawai', function ($q) {
                    $q->where('full_name', 'like', "%{$this->name}%");
                });
            })
            ->when($this->no_vt, function ($query) {
                $query->where('from_vt', 'like', "%{$this->no_vt}%");
            })
            ->when(isset($this->is_redeemed), function ($query) {
                $query->where('is_redeemed', $this->is_redeemed);
            })
            ->when($this->from_date || $this->to_date, function ($query) {
                $from = $this->from_date ?? now()->startOfDay();
                $to = $this->to_date ?? now()->endOfDay();
                $query->whereBetween('updated_at', [$from, $to]);
            })
            ->where('is_redeemable', 1)
            ->orderByDesc('updated_at')
            ->paginate(perPage: 10);
    }

    public function render()
    {
        return view('livewire.handler.point.technician.index', [
            'pointData' => $this->getData()
        ]);
    }
}
