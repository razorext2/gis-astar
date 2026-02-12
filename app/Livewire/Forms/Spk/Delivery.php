<?php

namespace App\Livewire\Forms\Spk;

use Livewire\Form;

class Delivery extends Form
{
    public ?string $nomor_sr = null;

    public ?string $via = null;

    public ?string $partay = null;

    public ?string $no_container = null;

    public ?string $nama_kapal = null;

    public ?string $no_plat = null;

    public ?string $nama_supir = null;

    public ?string $id_supir = null;

    public ?string $no_telp_supir = null;

    public ?string $berat = null;

    public ?string $etd = null;

    public ?string $eta = null;

    public ?string $note = null;

    public ?array $products = [];

    public ?array $is_delay = [];

    public ?array $history = [];

    protected function rules()
    {
        // buat role nya disini
    }
}
