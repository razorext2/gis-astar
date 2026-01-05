<?php

namespace App\Livewire\Forms\Spk;

use Livewire\Form;

class PackingList extends Form
{
    public ?string $nama_part = null;

    public ?int $qty = null;

    public ?string $satuan = null;

    public ?string $pack = null;

    public ?string $nama_box = null;

    protected $rules = [
        'nama_part' => 'required|string|min:5',
        'qty' => 'required|numeric|min:1',
        'satuan' => 'required|string|min:1',
        'pack' => 'required|string|min:1',
        'nama_box' => 'nullable|string|min:1',
    ];
}
