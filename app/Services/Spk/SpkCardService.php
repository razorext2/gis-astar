<?php

namespace App\Services\Spk;

use App\Models\Spk\Production;
use App\Models\Spk\SpkMain;

class SpkCardService
{
    public function getSpkCards()
    {
        $user = auth()->user();
        $canValidate = $user->can('spk-approve');

        // Jika user bisa validasi, tampilkan semua, jika tidak tampilkan milik dia saja
        $baseQuery = SpkMain::query();
        if (! $canValidate) {
            $baseQuery->where('added_by', $user->id);
        }

        return [
            [
                'permission' => 'all',
                'label' => 'Menunggu Validasi',
                'count' => (clone $baseQuery)->where('status_approval', 0)->count(),
                'indicator' => 'SPK',
                'icon' => 'icons.clipboard-check',
                'color' => 'red',
            ],
            [
                'permission' => 'all',
                'label' => 'SPK Booked',
                'count' => (clone $baseQuery)->where('is_booked', true)->count(),
                'indicator' => 'SPK',
                'icon' => 'icons.bookmark',
                'color' => 'yellow',
            ],
            [
                'permission' => 'all',
                'label' => 'Total SPK',
                'count' => (clone $baseQuery)->where('status_approval', 1)->count(),
                'indicator' => 'SPK',
                'icon' => 'icons.exclamation-circle',
                'color' => 'blue',
            ],
            [
                'permission' => 'all',
                'label' => 'SPK Selesai',
                'count' => (clone $baseQuery)->where('status', 6)->count(),
                'indicator' => 'SPK',
                'icon' => 'icons.badge-check',
                'color' => 'green',
            ],
        ];
    }

    public function getSpkPurchasingRequestCards()
    {
        $baseQuery = SpkMain::query()
            ->where('status_approval', 1)
            ->where('on_delay', 0);

        return [
            [
                'permission' => 'all',
                'label' => 'Belum Update PR',
                'count' => (clone $baseQuery)
                    ->where('is_using_old_stock', false)
                    ->whereNull('nomor_purchasing_request')
                    ->whereNull('nomor_purchasing_request_json')
                    ->count(),
                'indicator' => 'SPK',
                'icon' => 'icons.clipboard-check',
                'color' => 'red',
            ],
            [
                'permission' => 'all',
                'label' => 'Pakai Stok Lama',
                'count' => (clone $baseQuery)
                    ->where('is_using_old_stock', true)
                    ->count(),
                'indicator' => 'SPK',
                'icon' => 'icons.clipboard-check',
                'color' => 'blue',
            ],
            [
                'permission' => 'all',
                'label' => 'Sudah Update PR',
                'count' => (clone $baseQuery)
                    ->whereNotNull('nomor_purchasing_request')
                    ->orWhereNotNull('nomor_purchasing_request_json')
                    ->count(),
                'indicator' => 'SPK',
                'icon' => 'icons.clipboard-check',
                'color' => 'green',
            ],
        ];
    }

    public function getSpkProductionCards()
    {
        $baseQuery = Production::query();

        return [
            [
                'permission' => 'all',
                'label' => 'Belum Dikerjakan',
                'count' => (clone $baseQuery)
                    ->whereDoesntHave('productionHistories')
                    ->count(),
                'indicator' => 'SPK',
                'icon' => 'icons.close',
                'color' => 'red',
            ],
            [
                'permission' => 'all',
                'label' => 'Dalam Pengerjaan',
                'count' => (clone $baseQuery)
                    ->whereHas('productionHistories')
                    ->whereDoesntHave('productionHistories', function ($query) {
                        $query->where('status_produksi', 10);
                    })
                    ->count(),
                'indicator' => 'SPK',
                'icon' => 'icons.clipboard-check',
                'color' => 'blue',
            ],
            [
                'permission' => 'all',
                'label' => 'Selesai',
                'count' => (clone $baseQuery)
                    ->whereHas('productionHistories', function ($query) {
                        $query->where('status_produksi', 10);
                    })
                    ->count(),
                'indicator' => 'SPK',
                'icon' => 'icons.clipboard-check',
                'color' => 'green',
            ],
        ];
    }

    public function getSpkDeliveryCards()
    {
        $user = auth()->user();
        $canValidate = $user->can('spk-approve');

        $baseQuery = SpkMain::query()->whereHas('production',
            function ($production) use ($canValidate, $user) {
                if (! $canValidate) {
                    $production->where(function ($p) {
                        $p->whereRaw('COALESCE(JSON_LENGTH(packing_list), 0) > 0')
                            ->orWhere('is_using_company_driver', true)
                            ->orWhere('is_picked_up_by_customer', true);
                    })->where('added_by', $user->id);
                }

                $production->whereHas('productionHistories', function ($history) {
                    $history->where('status_produksi', 10)
                        ->whereRaw('id = (SELECT id FROM tb_produksi_histories
                                                WHERE tb_produksi_histories.id_produksi = tb_produksi.id
                                                ORDER BY created_at DESC
                                                LIMIT 1)
                                                ');
                });
            });

        if (! $canValidate) {
            $baseQuery->where('added_by', $user->id);
        }

        return [
            [
                'permission' => 'all',
                'label' => 'Perlu Dikirim',
                'count' => (clone $baseQuery)
                    ->whereDoesntHave('deliveries')
                    ->count(),
                'indicator' => 'SPK',
                'icon' => 'icons.close',
                'color' => 'yellow',
            ],
            [
                'permission' => 'all',
                'label' => 'Pengiriman Selesai',
                'count' => (clone $baseQuery)
                    ->whereHas('deliveries', function ($d) {
                        $d->where('status_kirim', 1);
                    })
                    ->count(),
                'indicator' => 'SPK',
                'icon' => 'icons.check',
                'color' => 'green',
            ],
        ];
    }

    public function getSpkBillingCards()
    {
        $baseQuery = SpkMain::query();
        $user = auth()->user();
        $canValidate = $user->can('spk-approve');

        if (! $canValidate) {
            $baseQuery->where('added_by', $user->id);
        }

        return [
            [
                'permission' => 'all',
                'label' => 'Belum Ditagih',
                'count' => (clone $baseQuery)
                    ->whereDoesntHave('noTagihanUpdatedBy')
                    ->count(),
                'indicator' => 'SPK',
                'icon' => 'icons.close',
                'color' => 'red',
            ],
            [
                'permission' => 'all',
                'label' => 'Dalam Proses Penagihan',
                'count' => (clone $baseQuery)
                    ->whereHas('noTagihanUpdatedBy')
                    ->count(),
                'indicator' => 'SPK',
                'icon' => 'icons.check',
                'color' => 'yellow',
            ],
        ];
    }

    public function getSpkDailyReportCards()
    {
        $baseQuery = SpkMain::query()
            ->where('status_approval', 1)
            ->where('status', '>=', 3);

        return [
            [
                'permission' => 'all',
                'label' => 'Proyek Belum Dilaporkan',
                'count' => (clone $baseQuery)
                    ->whereDoesntHave('project')
                    ->count(),
                'indicator' => 'Proyek',
                'icon' => 'icons.close',
                'color' => 'red',
            ],
            [
                'permission' => 'all',
                'label' => 'Proyek Dilaporkan',
                'count' => (clone $baseQuery)
                    ->whereHas('project')
                    ->count(),
                'indicator' => 'Proyek',
                'icon' => 'icons.lock-time',
                'color' => 'yellow',
            ],
        ];
    }
}
