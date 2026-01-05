<?php

namespace App\Models\Spk;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Production extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'tb_produksi';

    protected $fillable = [
        'id_spk',
        'assign_to',
        'packing_list',
    ];

    protected $casts = [
        'packing_list' => 'array',
    ];

    public function spk()
    {
        return $this->belongsTo(SpkMain::class, 'id_spk');
    }

    public function assignTo()
    {
        return $this->belongsTo(\App\Models\User::class, 'assign_to');
    }

    public function productionHistories()
    {
        return $this->hasMany(ProductionHistory::class, 'id_produksi', 'id');
    }
}
