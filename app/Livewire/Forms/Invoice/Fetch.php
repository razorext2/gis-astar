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

    #[Validate(rule: ['required', 'string', 'min:3', 'max:10'],
        message: [
            'required' => 'Kolom :attribute wajib diisi',
            'string' => 'Kolom :attribute harus berupa String',
            'min' => 'Kolom :attribute tidak boleh kurang dari :min karakter',
            'max' => 'Kolom :attribute tidak boleh lebih dari :max karakter',
        ],
        attribute: ['tipe_tagihan' => 'Tipe Tagihan'],
    )]
    public ?string $tipe_tagihan = null;

    public function fetchIdc()
    {
        // cek apakah nofakturpajak idcppn ada
        $data = Http::get('https://indodacin.nusa.net.id/web/finger/secureapi.php', [
            'tipe' => 'fetchBTT1',
            'NomorFakturPajak' => $this->nofakturpajak,
        ])->json();

        return $data;
    }

    public function fetchIdy()
    {
        // cek apakah nofakturpajak idy ppn ada
        $data = Http::get('https://indodacin.nusa.net.id/web/finger/secureapi.php', [
            'tipe' => 'fetchBTT2',
            'NomorFakturPajak' => $this->nofakturpajak,
        ])->json();

        return $data;
    }
}
