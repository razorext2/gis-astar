<?php

namespace App\Livewire\Forms\Invoice;

use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Validate;
use Livewire\Form;

class Fetch extends Form
{
    #[Validate('required', message: 'No. Faktur Pajak harus diisi')]
    #[Validate('string', message: 'No. Faktur Pajak harus berupa String')]
    #[Validate('max:20', message: 'No. Faktur Pajak tidak boleh lebih dari 20 karakter')]
    #[Validate('min:8', message: 'No. Faktur Pajak tidak boleh kurang dari 8 karakter')]
    public $nofakturpajak;

    public function fetch()
    {
        // cek apakah nofakturpajak ada
        $data = Http::get("https://indodacin.nusa.net.id/web/finger/secureapi.php", [
            'tipe' => 'fetchBTT1',
            'NomorFakturPajak' => $this->nofakturpajak,
        ])->json();

        return $data;
    }
}
