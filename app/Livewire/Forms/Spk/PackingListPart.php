<?php

namespace App\Livewire\Forms\Spk;

use Livewire\Form;

class PackingListPart extends Form
{
    public ?string $nama_part = null;

    public ?int $qty = null;

    public ?string $satuan = null;

    public ?string $pack = null;

    public ?string $nama_box = null;

    protected function rules()
    {
        return
          [
              'nama_part' => 'required|string|min:5',
              'qty' => 'required|numeric|min:1',
              'satuan' => 'required|string|min:1',
              'pack' => 'required|string|min:1',
              'nama_box' => 'nullable|string|min:1',
          ];
    }

    protected $messages = [
        'nama_part.required' => 'Nama part wajib diisi.',
        'nama_part.string' => 'Nama part harus berupa string.',
        'nama_part.min' => 'Nama part minimal berisi 5 karakter.',
        'qty.required' => 'Jumlah part wajib diisi.',
        'qty.numeric' => 'Jumlah part harus berupa angka.',
        'qty.min' => 'Jumlah part minimal 1 buah.',
        'satuan.required' => 'Satuan wajib diisi.',
        'satuan.string' => 'Satuan harus berupa string.',
        'satuan.min' => 'Satuan minimal berisi 1 karakter.',
        'pack.required' => 'Pack wajib diisi.',
        'pack.string' => 'Pack harus berupa string.',
        'pack.min' => 'Pack minimal berisi 1 karakter.',
        'nama_box.string' => 'Nama box harus berupa string.',
    ];
}
