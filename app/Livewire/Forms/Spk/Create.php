<?php

namespace App\Livewire\Forms\Spk;

use Livewire\Attributes\Validate;
use Livewire\Form;

class Create extends Form
{
    #[Validate(
        ['required', 'max:255', 'string'],
        message: [
            'required' => 'Kolom :attribute wajib diisi.',
            'max' => 'Kolom :attribute maksimal 255 karakter.',
            'string' => 'Kolom :attribute harus berupa teks.',
        ],
        attribute: [
            'nama_customer' => 'Nama bon customer',
        ],
    )]
    public ?string $nama_customer;

    #[Validate(
        ['nullable', 'max:255', 'string'],
        message: [
            'max' => 'Kolom :attribute maksimal 255 karakter.',
            'string' => 'Kolom :attribute harus berupa teks.',
        ],
        attribute: [
            'no_telp' => 'nomor telepon customer',
        ],
    )]
    public ?string $no_telp;

    #[Validate(
        ['nullable', 'max:255', 'string'],
        message: [
            'max' => 'Kolom :attribute maksimal 255 karakter.',
            'string' => 'Kolom :attribute harus berupa teks.',
        ],
        attribute: [
            'contact_person' => 'contact person',
        ],
    )]
    public ?string $contact_person;

    #[Validate(
        ['nullable', 'string'],
        message: [
            'string' => 'Kolom :attribute harus berupa teks.',
        ],
        attribute: [
            'alamat_customer' => 'alamat customer',
        ],
    )]
    public ?string $alamat_customer;

    #[Validate(['required', 'string'],
        message: [
            'required' => 'Kolom :attribute wajib diisi.',
            'string' => 'Kolom :attribute harus berupa teks.',
        ],
        attribute: [
            'tipe_timbangan' => 'tipe timbangan',
        ])]
    public ?string $tipe_timbangan;

    #[Validate(
        ['required', 'array', 'min:1'],
        message: [
            'required' => 'Kolom :attribute wajib diisi.',
            'array' => 'Kolom :attribute harus berupa array.',
            'min' => 'Kolom :attribute minimal berisi satu barang.',
        ],
        attribute: [
            'barang' => 'daftar barang',
        ],
    )]
    public array $barang = [];

    #[Validate(
        ['required', 'string', 'in:idcnon,idcppn,idyppn'],
        message: [
            'required' => 'Kolom :attribute wajib diisi.',
            'string' => 'Kolom :attribute harus berupa teks.',
            'in' => 'Pilihan :attribute tidak valid.',
        ],
        attribute: [
            'tipe_tagihan' => 'tipe tagihan',
        ],
    )]
    public ?string $tipe_tagihan = 'idcppn';

    #[Validate(
        ['required', 'integer', 'in:0,1'],
        message: [
            'required' => 'Kolom :attribute wajib diisi.',
            'integer' => 'Kolom :attribute harus berupa angka.',
            'in' => 'Pilihan :attribute tidak valid.',
        ],
        attribute: [
            'status_nomor_tagihan' => 'status nomor tagihan',
        ],
    )]
    public ?int $status_nomor_tagihan = 0;

    #[Validate(
        ['nullable', 'string', 'max:255', 'required_if:status_nomor_tagihan,1'],
        message: [
            'string' => 'Kolom :attribute harus berupa teks.',
            'max' => 'Kolom :attribute maksimal 255 karakter.',
            'required_if' => 'Kolom :attribute wajib diisi ketika status nomor tagihan sudah ada.',
        ],
        attribute: [
            'nomor_tagihan' => 'nomor tagihan',
        ],
    )]
    public ?string $nomor_tagihan = null;

    #[Validate(
        ['required', 'string', 'max:255', 'unique:App\Models\Spk\SpkMain,nomor_order'],
        message: [
            'required' => 'Kolom :attribute wajib diisi.',
            'string' => 'Kolom :attribute harus berupa teks.',
            'max' => 'Kolom :attribute maksimal 255 karakter.',
            'unique' => 'Nomor order sudah digunakan, silahkan input nomor order baru.',
        ],
        attribute: [
            'nomor_order' => 'nomor order',
        ],
    )]
    public ?string $nomor_order;

    #[Validate(
        ['required', 'string', 'in:Cash,Bon'],
        message: [
            'required' => 'Kolom :attribute wajib diisi.',
            'string' => 'Kolom :attribute harus berupa teks.',
            'in' => 'Pilihan :attribute tidak valid.',
        ],
        attribute: [
            'tipe_bayar' => 'tipe bayar',
        ],
    )]
    public ?string $tipe_bayar;

    #[Validate(
        ['date'],
        message: [
            'required' => 'Kolom :attribute wajib diisi.',
            'date' => 'Format :attribute tidak valid.',
        ],
        attribute: [
            'tgl_cetak' => 'tanggal cetak',
        ],
    )]
    public ?string $tgl_cetak = null;

    #[Validate(
        ['integer'],
        message: [
            'required' => 'Kolom :attribute wajib diisi.',
            'integer' => 'Format :attribute tidak valid.',
        ],
        attribute: [
            'tgl_kirim' => 'tanggal kirim',
        ],
    )]
    public ?string $tgl_kirim = null;

    #[Validate(
        ['required', 'string'],
        message: [
            'required' => 'Kolom :attribute wajib diisi.',
            'string' => 'Kolom :attribute harus berupa teks.',
        ],
        attribute: [
            'keterangan' => 'keterangan',
        ],
    )]
    public ?string $keterangan;

    #[Validate(
        ['required', 'integer'],
        message: [
            'required' => 'Kolom :attribute wajib diisi.',
            'integer' => 'Kolom :attribute harus berupa angka.',
        ],
        attribute: [
            'assign_to' => 'assign to',
        ],
    )]
    public ?int $assign_to;
}
