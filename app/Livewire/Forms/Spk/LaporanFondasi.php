<?php

namespace App\Livewire\Forms\Spk;

use Livewire\Attributes\Validate;
use Livewire\Form;

class LaporanFondasi extends Form
{
    #[Validate(
        rule: ['required', 'string', 'min:5'],
        message: [
            'required' => 'Kolom :attribute wajib diisi.',
            'string' => 'Kolom :attribute harus berupa teks.',
            'min' => 'Kolom :attribute minimal berjumlah 5 karakter.',
        ],
        attribute: [
            'title' => 'judul',
        ]
    )]
    public ?string $title;

    #[Validate(
        rule: ['required', 'integer', 'max:100'],
        message: [
            'required' => 'Kolom :attribute wajib diisi.',
            'integer' => 'Kolom :attribute harus berupa angka.',
        ],
        attribute: [
            'progress' => 'progres',
        ]
    )]
    public ?string $progress;

    #[Validate(
        rule: ['required', 'string', 'min:10'],
        message: [
            'required' => 'Kolom :attribute wajib diisi.',
            'string' => 'Kolom :attribute harus berupa teks.',
            'min' => 'Kolom :attribute minimal berjumlah 10 karakter.',
        ],
        attribute: [
            'description' => 'keterangan',
        ]
    )]
    public ?string $description;

    #[Validate(
        rule: [
            'documentations' => ['required', 'array', 'min:1'],
            'documentations.*' => 'image|mimes:jpg,jpeg,png|min:20|max:2048',
        ],
        message: [
            'documentations.required' => 'Kolom :attribute wajib diisi.',
            'documentations.array' => 'Kolom :attribute harus berupa array file.',
            'documentations.min' => 'Minimal unggah satu :attribute.',
            'documentations.*.image' => 'Setiap :attribute harus berupa file gambar.',
            'documentations.*.mimes' => 'Format :attribute harus jpg, jpeg, atau png.',
            'documentations.*.min' => 'Ukuran :attribute minimal 20KB per file.',
            'documentations.*.max' => 'Ukuran :attribute maksimal 2MB per file.',
        ],
        attribute: [
            'documentations' => 'dokumentasi',
            'documentations.*' => 'dokumentasi',
        ]
    )]
    public ?array $documentations = [];

    #[Validate(
        rule: [
            'newDocumentations.*' => 'image|mimes:jpg,jpeg,png|min:20|max:2048',
        ],
        message: [
            'newDocumentations.*.image' => 'Setiap :attribute harus berupa file gambar.',
            'newDocumentations.*.mimes' => 'Format :attribute harus jpg, jpeg, atau png.',
            'newDocumentations.*.min' => 'Ukuran :attribute minimal 20KB per file.',
            'newDocumentations.*.max' => 'Ukuran :attribute maksimal 2MB per file.',
        ],
        attribute: [
            'newDocumentations' => 'dokumentasi',
            'newDocumentations.*' => 'dokumentasi',
        ]
    )]
    public ?array $newDocumentations = [];
}
