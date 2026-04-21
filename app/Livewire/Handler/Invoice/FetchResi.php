<?php

namespace App\Livewire\Handler\Invoice;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class FetchResi extends Component
{
    public ?string $resi = null;

    public ?array $data = null;

    public ?string $error = null;

    public function mount($resi)
    {
        $this->resi = $resi;
    }

    public function fetchResi()
    {
        $this->reset('error', 'data');

        if (! $this->resi || $this->resi == '0') {
            $this->error = 'Nomor Resi tidak valid.';
            return;
        }

        $cacheKey = "resi-tracking-{$this->resi}";

        if (Cache::has($cacheKey)) {
            $this->data = Cache::get($cacheKey);
            return;
        }

        try {
            $api_key = config('services.binderbyte.api_key');
            $url = "https://api.binderbyte.com/v1/track?api_key={$api_key}&courier=tiki&awb={$this->resi}";

            $response = Http::timeout(15)->get($url);

            if (! $response->successful()) {
                $this->error = 'Gagal menghubungi server pelacakan. Silakan coba lagi nanti.';
                return;
            }

            $result = $response->json();

            if (($result['status'] ?? 0) !== 200) {
                $this->error = $result['message'] ?? 'Nomor resi tidak ditemukan atau terjadi kesalahan.';
                return;
            }

            $this->data = $result;
            Cache::put($cacheKey, $this->data, now()->addHours(1));

        } catch (\Exception $e) {
            $this->error = 'Terjadi kesalahan saat mengambil data: ' . $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.handler.invoice.fetch-resi');
    }
}
