<?php

namespace App\Models\Spk;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class SpkHistory extends Model
{
    use HasUuids;

    protected $table = 'tb_spk_histories';

    protected $fillable = [
        'spk_id',
        'title',
        'keterangan',
        'added_by',
    ];

    public function addedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'added_by', 'id');
    }
}
