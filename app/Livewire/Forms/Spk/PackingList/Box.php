<?php

namespace App\Livewire\Forms\Spk\PackingList;

use Livewire\Form;

class Box extends Form
{
    public ?string $box_name = null;

    public ?string $customer_name = null;

    public ?string $satuan_barang = null;

    public ?string $title = null;

    public int $kitRow = 1;

    public ?int $qty_barang = 1;

    public array $boxs = [];

    public function validateBox()
    {
        $this->validate(
            rules: [
                'box_name' => 'required|string|min:5',
            ],
            messages: [
                'box_name.required' => 'Nama box harus diisi.',
                'box_name.string' => 'Nama box harus berupa string.',
                'box_name.min' => 'Nama box minimal 5 karakter.',
            ]);
    }

    public function validatePacking()
    {
        $this->validate(
            rules: [
                'boxs' => 'required|array|min:1',
                'customer_name' => 'required|string|min:5',
                'title' => 'required|string|min:5',
                'qty_barang' => 'required|integer|min:1',
                'satuan_barang' => 'required|string',
            ],
            messages: [
                'boxs.required' => 'Minimal harus ada 1 peti.',
                'customer_name.required' => 'Nama pelanggan harus diisi.',
                'customer_name.string' => 'Nama pelanggan harus berupa string.',
                'customer_name.min' => 'Nama pelanggan minimal 5 karakter.',
                'title.required' => 'Judul harus diisi.',
                'title.string' => 'Judul harus berupa string.',
                'title.min' => 'Judul minimal 5 karakter.',
                'qty_barang.required' => 'Jumlah barang harus diisi.',
                'qty_barang.integer' => 'Jumlah barang harus berupa integer.',
                'qty_barang.min' => 'Jumlah barang minimal 1.',
                'satuan_barang.required' => 'Satuan barang harus diisi.',
                'satuan_barang.string' => 'Satuan barang harus berupa string.',
            ]
        );
    }
}
