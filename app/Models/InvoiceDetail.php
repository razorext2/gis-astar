<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceDetail extends Model
{
    use HasUlids, SoftDeletes;

    protected $table = 'tb_invoice_detail';
    protected $fillable = [
        'no_faktur_pajak',
        'status_btt',
        'status',
        'informasi_pengiriman',
        'documentations',
        'added_by',
    ];
    protected $casts = [
        'informasi_pengiriman' => 'array',
        'documentations' => 'array',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'no_faktur_pajak', 'no_faktur_pajak');
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }
}
