<?php

namespace App\Livewire\Dashboard;

use App\Models\Sales;
use Carbon\Carbon;
use Livewire\Component;

class UserSalesStats extends Component
{
    public function render()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $kode_pegawai = $user->kode_pegawai;
        
        $salesBase = Sales::where('kode_pegawai', $kode_pegawai);

        // Total sales
        $total = (clone $salesBase);
        $sales_total = $total->count();
        $sales_approved = $total->where('status', 1)->count();
        $sales_approved_percentage = $sales_total > 0 ? ($sales_approved / $sales_total) * 100 : 0;

        // Daily
        $startDay = Carbon::now()->startOfDay();
        $endDay = Carbon::now()->endOfDay();
        $daily = (clone $salesBase)->whereBetween('created_at', [$startDay, $endDay]);
        $sales_total_daily = $daily->count();
        $sales_approved_daily = $daily->where('status', 1)->count();
        $sales_approved_percentage_daily = $sales_total_daily > 0 ? ($sales_approved_daily / $sales_total_daily) * 100 : 0;

        // Monthly
        $startMonth = Carbon::now()->startOfMonth();
        $endMonth = Carbon::now()->endOfMonth();
        $monthly = (clone $salesBase)->whereBetween('created_at', [$startMonth, $endMonth]);
        $sales_total_monthly = $monthly->count();
        $sales_approved_monthly = $monthly->where('status', 1)->count();
        $sales_approved_percentage_monthly = $sales_total_monthly > 0 ? ($sales_approved_monthly / $sales_total_monthly) * 100 : 0;

        return view('livewire.dashboard.user-sales-stats', [
            'sales_total' => $sales_total,
            'sales_approved' => $sales_approved,
            'sales_approved_percentage' => $sales_approved_percentage,
            'sales_total_daily' => $sales_total_daily,
            'sales_approved_daily' => $sales_approved_daily,
            'sales_approved_percentage_daily' => $sales_approved_percentage_daily,
            'sales_total_monthly' => $sales_total_monthly,
            'sales_approved_monthly' => $sales_approved_monthly,
            'sales_approved_percentage_monthly' => $sales_approved_percentage_monthly,
        ]);
    }
}
