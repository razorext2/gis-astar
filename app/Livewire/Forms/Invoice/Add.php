<?php

namespace App\Livewire\Forms\Invoice;

use Livewire\Attributes\Validate;
use Livewire\Form;

class Add extends Form
{
    #[Validate(['required', 'string', 'max:50'])]
    public $btt_number = '';

    #[Validate(['required', 'string', 'max:50'])]
    public $btt_created_at = '';

    #[Validate(['required', 'string', 'max:100'])]
    public $company_name = '';

    #[Validate(['required', 'string', 'max:50'])]
    public $invoice_date = '';

    #[Validate(['required', 'string', 'max:64'])]
    public $receivable_number = '';

    #[Validate(['required', 'string', 'max:64'])]
    public $sale_number = '';

    #[Validate(['required', 'string', 'max:64'])]
    public $tax_number = '';

    #[Validate(['required', 'string', 'max:200'])]
    public $newest_status = '';

    #[Validate(['nullable', 'string', 'max:50'])]
    public $resi_number = '';

    #[Validate(['string', 'max:30'])]
    public string $invoice_type = '';

    #[Validate(['string', 'max:30'])]
    public string $invoice_destination = '';

    #[Validate(['max:30'])]
    public ?int $delivery_status = null;

    #[Validate(['documentations.*' => 'image|max:4096'])]
    public $documentations = [];
}
