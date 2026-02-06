<?php

namespace App\Livewire\Forms\Spk;

use Illuminate\Support\Str;
use Livewire\Form;

class PackingListItem extends Form
{
    public ?string $cara_input = null;

    public ?string $nama_ekspedisi = null;

    public ?string $nama_barang = null;

    public ?int $qty_barang = null;

    public ?string $satuan_barang = null;

    public ?string $note = null;

    public array $parts = [];

    protected function rules()
    {
        $rules = [
            'nama_ekspedisi' => 'required|string|min:3',
            'nama_barang' => 'required|min:5|string',
            'qty_barang' => 'required|numeric|min:1',
            'satuan_barang' => 'required|string',
            'note' => 'required|string|min:10',
            'cara_input' => 'required',
        ];

        if ($this->cara_input === 'manual') {
            $rules['parts'] = 'required|array|min:1';
        }

        return $rules;
    }

    protected $messages = [
        'nama_ekspedisi.required' => 'Nama ekspedisi wajib diisi.',
        'nama_ekspedisi.string' => 'Nama ekspedisi harus berupa string.',
        'nama_ekspedisi.min' => 'Nama ekspedisi minimal berisi 3 karakter.',
        'nama_barang.required' => 'Nama barang wajib diisi.',
        'nama_barang.min' => 'Nama barang minimal berisi 5 karakter.',
        'nama_barang.string' => 'Nama barang harus berupa string.',
        'qty_barang.required' => 'Jumlah barang wajib diisi.',
        'qty_barang.numeric' => 'Jumlah barang harus berupa angka.',
        'qty_barang.min' => 'Jumlah barang minimal 1 buah.',
        'satuan_barang.required' => 'Satuan wajib diisi.',
        'satuan_barang.string' => 'Satuan harus berupa string.',
        'cara_input.required' => 'Cara input wajib diisi.',
        'note.required' => 'Note wajib diisi.',
        'note.min' => 'Note minimal berisi 10 karakter.',
        'note.string' => 'Note harus berupa string.',
        'parts.required' => 'Daftar part wajib diisi.',
        'parts.array' => 'Daftar part harus berupa array.',
        'parts.min' => 'Daftar part minimal berjumlah 1 buah.',
    ];

    public function generateBarangBaru($lampiran = null)
    {
        return [
            'id_barang' => Str::uuid(),
            'files' => $this->cara_input === 'upload' ? $lampiran : [],
            'packing_list_type' => $this->cara_input,
            'nama_ekspedisi' => $this->nama_ekspedisi,
            'nama_barang' => $this->nama_barang,
            'qty_barang' => $this->qty_barang,
            'satuan_barang' => $this->satuan_barang,
            'note' => $this->note,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function clearForm()
    {
        $this->nama_ekspedisi = null;
        $this->nama_barang = null;
        $this->satuan_barang = null;
        $this->qty_barang = null;
        $this->note = null;
        $this->parts = [];
    }
}
