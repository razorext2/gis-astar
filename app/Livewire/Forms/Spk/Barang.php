<?php

namespace App\Livewire\Forms\Spk;

use Livewire\Form;

class Barang extends Form
{
    public ?string $nama_barang;

    public ?int $jumlah_unit;

    public ?string $satuan_barang;

    public ?string $spesifikasi = null;

    public ?string $index_barang = null;

    public array $rules = [
        'nama_barang' => 'required|min:5|string',
        'jumlah_unit' => 'required|numeric|min:1',
        'satuan_barang' => 'required|string',
        'spesifikasi' => 'nullable|string',
    ];

    public array $messages = [
        'nama_barang.required' => 'Kolom nama barang wajib diisi.',
        'nama_barang.min' => 'Kolom nama barang minimal berisi 5 karakter.',
        'nama_barang.string' => 'Kolom nama barang harus berupa string.',
        'jumlah_unit.required' => 'Kolom jumlah unit wajib diisi.',
        'jumlah_unit.numeric' => 'Kolom jumlah unit harus berupa angka.',
        'jumlah_unit.min' => 'Kolom jumlah unit minimal berjumlah 1 buah.',
        'satuan_barang.required' => 'Kolom satuan wajib diisi.',
        'satuan_barang.string' => 'Kolom harus berupa string.',
        'spesifikasi.string' => 'Kolom spesifikasi harus berupa string.',
    ];

    public function resetBarang(bool $is_edit)
    {
        if ($is_edit && $this->index_barang !== null) {
            // reset edit state
            $is_edit = false;
            $this->index_barang = null;
        }

        $this->nama_barang = null;
        $this->jumlah_unit = null;
        $this->satuan_barang = null;
        $this->spesifikasi = null;

        return $is_edit;
    }
}
