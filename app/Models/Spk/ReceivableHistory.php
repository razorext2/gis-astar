<?php

namespace App\Models\Spk;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceivableHistory extends Model
{
    use HasUlids, SoftDeletes;

    protected $table = 'tb_spk_receivable_histories';

    protected $fillable = [
        'spk_id',
        'nomor_sr',
        'total_piutang',
        'sisa_piutang_sebelum',
        'sisa_piutang_sesudah',
        'selisih',
        'source',
        'updated_by',
        'checked_at',
    ];

    public function spk()
    {
        return $this->belongsTo(SpkMain::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
