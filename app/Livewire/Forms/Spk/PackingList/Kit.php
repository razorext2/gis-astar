<?php

namespace App\Livewire\Forms\Spk\PackingList;

use Livewire\Form;

class Kit extends Form
{
    public array $kits = [
        [
            'kit_name' => '',
            'kit_qty' => '',
            'kit_unit' => '',
        ],
    ];

    public $rules = [
        'kits' => 'required|array|min:1',
        'kits.*.kit_name' => 'required|string|min:5|max:255',
        'kits.*.kit_qty' => 'required|integer|min:1',
        'kits.*.kit_unit' => 'required|string',
    ];

    public $messages = [
        'kits.required' => 'Minimal harus ada 1 item.',
        'kits.*.kit_name.required' => 'Nama kit harus diisi.',
        'kits.*.kit_qty.required' => 'Jumlah kit harus diisi.',
        'kits.*.kit_unit.required' => 'Satuan kit harus diisi.',
        'kits.*.kit_qty.integer' => 'Jumlah kit harus berupa angka.',
        'kits.*.kit_qty.min' => 'Jumlah kit minimal berjumlah 1 buah.',
    ];

    public function add()
    {
        // $this->validate();

        $this->kits[] = [
            'kit_name' => '',
            'kit_qty' => '',
            'kit_unit' => '',
        ];

        return $this->kits;
    }

    public function remove($i)
    {
        if (! isset($this->kits[$i])) {
            return;
        }

        unset($this->kits[$i]);

        // Reindex array agar Livewire tidak error
        return $this->kits = array_values($this->kits);
    }

    public function validateKit()
    {
        $this->validate();
    }
}
