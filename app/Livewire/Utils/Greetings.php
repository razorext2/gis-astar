<?php

namespace App\Livewire\Utils;

use Carbon\Carbon;
use Livewire\Component;

class Greetings extends Component
{
    public $greet;

    public $pesan;

    public function mount()
    {
        $hour = Carbon::now()->hour;

        if ($hour >= 5 && $hour <= 10) {
            $this->greet = 'Selamat pagi,';
        } elseif ($hour >= 11 && $hour <= 15) {
            $this->greet = 'Selamat siang,';
        } elseif ($hour >= 16 && $hour <= 19) {
            $this->greet = 'Selamat sore,';
        } else {
            $this->greet = 'Selamat malam,';
        }

        try {
            // Fetch live API insight/quote
            $response = \Illuminate\Support\Facades\Http::timeout(2)->get('https://zenquotes.io/api/random');

            if ($response->successful() && isset($response->json()[0]['q'])) {
                $quote = $response->json()[0];
                $this->pesan = $quote['q'].' — '.$quote['a'];
            } else {
                $this->pesan = 'Setiap hari adalah kesempatan baru untuk menjadi lebih baik.';
            }
        } catch (\Exception $e) {
            $this->pesan = 'Setiap hari adalah kesempatan baru untuk menjadi lebih baik.';
        }
    }

    public function render()
    {
        return view('livewire.utils.greetings');
    }
}
