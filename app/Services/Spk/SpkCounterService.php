<?php

namespace App\Services\Spk;

use App\Models\Spk\Production;
use App\Models\Spk\SpkMain;

class SpkCounterService
{
    public function user()
    {
        return auth()->user();
    }

    public function countNeedsValidation()
    {
        if ($this->user()->can('spk-validate')) {
            return SpkMain::where('status_approval', 0)->count();
        } else {
            return SpkMain::where('status_approval', 0)
                ->where('added_by', $this->user()->id)
                ->count();
        }
    }

    public function countNeedsAssignPurchasingRequestNumber()
    {
        return SpkMain::where('status_nomor_tagihan', 0)
            ->where('is_using_old_stock', 0)
            ->where('status_approval', 1)
            ->where('on_delay', 0)
            ->whereNull('nomor_purchasing_request')
            ->whereNull('nomor_purchasing_request_json')
            ->count();
    }

    public function countSpkDoesNotHaveProductionProgress()
    {
        if ($this->user()->can('produksi-validate')) {
            return Production::whereHas('productionHistories', function ($history) {
                $history->where('status_produksi', 0);
            })->orWhereDoesntHave('productionHistories')
                ->count();
        } else {
            return Production::where('assign_to', $this->user()->id)
                ->whereHas('productionHistories', function ($history) {
                    $history->where('status_produksi', 0);
                })
                ->count();
        }
    }

    public function countSpkDoesNotOnDelivery()
    {
        $query = SpkMain::whereHas('production', function ($production) {
            $production->whereHas('productionHistories', function ($history) {
                $history->latest()->where('status_produksi', 10);
            });

            if ($this->user()->cannot('spk-validate')) {
                $production->whereRaw('COALESCE(JSON_LENGTH(packing_list), 0) > 0')
                    ->orWhere('is_using_company_driver', true)
                    ->orWhere('is_picked_up_by_customer', true);
            }
        })
            ->whereDoesntHave('deliveries');

        if ($this->user()->cannot('spk-validate')) {
            $query->where('added_by', $this->user()->id);
        }

        return $query->count();
    }
}
