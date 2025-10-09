<?php

namespace App\Livewire\Handler\Invoice;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class FetchResi extends Component
{
    public ?string $resi = null;
    public ?array $data = null;

    public function mount($resi)
    {
        $this->resi = $resi;
    }

    public function fetchResi()
    {
        $cacheKey = "resi-tracking-{$this->resi}";

        if (Cache::has($cacheKey)) {
            return $this->data = Cache::get($cacheKey);
        }

        $api_key = "4d406024c9fb5df8d5a8ec047fe6d9269eff87422bd3d4a8bfda4b8a16b95dfd";
        $url = "https://api.binderbyte.com/v1/track?api_key={$api_key}&courier=tiki&awb={$this->resi}";

        $response = Http::timeout(10)->get($url);

        if (!$response->successful()) {
            return [
                'status' => 500,
                'info' => 'request time out',
            ];
        }

        $this->data = $response->json();

        Cache::put($cacheKey, $this->data, now()->addHours(1));

        return $this->data;
    }

    public function render()
    {
        return view('livewire.handler.invoice.fetch-resi');
    }
}
