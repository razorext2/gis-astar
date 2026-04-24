<?php

/** Goal: Logika export invoice dengan filter tanggal, wilayah, dan tipe tagihan, Caller: Dashboard Invoice, Deps: ExportInvoiceToExcelJob, Invoice */

namespace App\Livewire\Handler\Invoice;

use App\Jobs\ExportInvoiceToExcelJob;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Export extends Component
{
    /** Status modal sync dengan Alpine.js */
    public bool $showModal = false;

    #[Validate('required|date')]
    public string $fromDate = '';

    #[Validate('required|date|after_or_equal:fromDate')]
    public string $toDate = '';

    #[Validate('required|string')]
    public string $region = 'all';

    #[Validate('nullable|string')]
    public ?string $tipeTagihan = 'all';

    /** Format tanggal default pada saat komponen dimuat */
    public function mount(): void
    {
        $this->fromDate = Carbon::today()->startOfWeek()->toDateString();
        $this->toDate = Carbon::today()->startOfWeek()->addDays(5)->toDateString();
    }

    /** Set periode harian */
    public function showDaily(): void
    {
        $this->fromDate = Carbon::today()->startOfDay()->toDateString();
        $this->toDate = Carbon::tomorrow()->endOfDay()->toDateString();
    }

    /** Set periode mingguan */
    public function showWeekly(): void
    {
        $this->fromDate = Carbon::today()->startOfWeek()->toDateString();
        $this->toDate = Carbon::today()->endOfWeek()->toDateString();
    }

    /** Set periode bulanan */
    public function showMonthly(): void
    {
        $this->fromDate = Carbon::today()->startOfMonth()->toDateString();
        $this->toDate = Carbon::today()->endOfMonth()->toDateString();
    }

    /** Set periode tahunan */
    public function showYearly(): void
    {
        $this->fromDate = Carbon::today()->startOfYear()->toDateString();
        $this->toDate = Carbon::today()->endOfYear()->toDateString();
    }

    /**
     * Mengambil daftar wilayah yang tersedia berdasarkan permission user
     */
    #[Computed]
    public function availableRegions(): array
    {
        $user = Auth::user();
        $regions = [];

        if ($user->can('invoice-export-all')) {
            $regions['all'] = 'Semua Invoice';
        }

        $permissionMap = [
            'invoice-export-cust'  => ['cust' => 'Direct Customer'],
            'invoice-export-medan' => ['medan' => 'Invoice Medan'],
            'invoice-export-pku'   => ['pku' => 'Invoice Pekanbaru'],
            'invoice-export-jkt'   => ['jkt' => 'Invoice Jakarta'],
        ];

        foreach ($permissionMap as $permission => $mapping) {
            if ($user->can($permission)) {
                $regions = array_merge($regions, $mapping);
            }
        }

        return $regions;
    }

    /**
     * Memproses export data ke file Excel via Background Job
     */
    public function export()
    {
        $this->validate();

        $query = Invoice::query()
            ->whereDate('created_at', '>=', $this->fromDate)
            ->whereDate('created_at', '<=', $this->toDate);

        // Filter by region → tipe_invoice
        if ($this->region !== 'all') {
            $tipeInvoiceMap = [
                'medan' => 'dalkot',
                'cust'  => 'lukot',
                'pku'   => 'lukot',
                'jkt'   => 'lukot',
            ];

            if (isset($tipeInvoiceMap[$this->region])) {
                $query->where('tipe_invoice', $tipeInvoiceMap[$this->region]);
            }
        }

        // Filter by tipe tagihan
        if ($this->tipeTagihan && $this->tipeTagihan !== 'all') {
            $query->where('tipe_tagihan', $this->tipeTagihan);
        }

        if (! $query->exists()) {
            return $this->dispatch('swal', title: 'Gagal', text: 'Data tidak ditemukan untuk periode dan wilayah ini', icon: 'error');
        }

        ExportInvoiceToExcelJob::dispatch(
            Auth::id(),
            $this->fromDate,
            $this->toDate,
            $this->region,
            $this->tipeTagihan
        )->delay(now()->addSeconds(2));

        $this->showModal = false;

        return $this->dispatch('swal',
            title: 'Berhasil',
            text: 'Permintaan export sedang diproses. Silahkan cek menu notifikasi nanti.',
            icon: 'success'
        );
    }

    public function render()
    {
        return view('livewire.handler.invoice.export', [
            'regions' => $this->availableRegions(),
        ]);
    }
}
