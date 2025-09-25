<?php

namespace App\Livewire\Forms\Invoice;

use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Validate;
use Livewire\Form;

class Fetch extends Form
{
    #[Validate(['required', 'string', 'max:50'])]
    public $btt;

    public function fetch()
    {
        // cek apakah btt ada
        $data = Http::get("https://indodacin.nusa.net.id/web/finger/secureapi.php", [
            'tipe' => 'fetchBTT1',
            'NomorFakturPajak' => $this->btt,
        ])->json();

        return $data;
    }
}
