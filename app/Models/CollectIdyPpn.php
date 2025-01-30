<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CollectIdyPpn extends Model
{
    use SoftDeletes;
    protected $table = "tb_collect_idy_ppn";
    protected $fillable = [
        'no_sr',
        'sales_invoice',
        'tax_invoice',
        'collect_type',
        'sr_type',
        'sr_date',
        'customer_name',
        'customer_recipient',
        'customer_address',
        'customer_telp',
        'customer_fax',
        'shipping_address',
        'total_bill',
        'remaining_bill',
        'assign_by',
        'assign_to',
        'assign_date',
        'bill_status',
        'validate_by',
    ];

    protected $attributes = [
        'assign_by' => null,
        'bill_status' => 0,
    ];

    public function pegawaiRelasi()
    {
        return $this->belongsTo(Pegawai::class, 'assign_to', 'kode_pegawai');
    }

    public function userRelasi()
    {
        return $this->belongsTo(User::class, 'assign_to', 'kode_pegawai');
    }

    public function collectRelasi()
    {
        return $this->hasMany(Collector::class, 'no_sr', 'no_sr');
    }

    public function getShortCustomerNameAttribute()
    {
        $words = explode(' ', $this->customer_name);
        if (count($words) > 4) {
            return implode(' ', array_slice($words, 0, 4)) . ' ...';
        }
        return $this->customer_name;
    }

    public function getShortCustomerAddressAttribute()
    {
        $words = explode(' ', $this->customer_address);
        if (count($words) > 5) {
            return implode(' ', array_slice($words, 0, 8)) . ' ...';
        }
        return $this->customer_address;
    }
}
