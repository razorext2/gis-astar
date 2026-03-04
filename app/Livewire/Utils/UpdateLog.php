<?php

namespace App\Livewire\Utils;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class UpdateLog extends Component
{
    public ?bool $showLogUpdateModal = false;

    public function logHistories()
    {
        if ($this->showLogUpdateModal !== true) {
            return collect();
        }

        $response = Http::withToken(config('services.github.token'))
            ->timeout(10)
            ->get('https://api.github.com/repos/razorext2/faceAttendanceV2/commits', [
                'per_page' => 10,
            ]);

        if (! $response->successful()) {
            return collect();
        }

        return collect($response->json());
    }

    public function render()
    {
        return view('livewire.utils.update-log');
    }
}
