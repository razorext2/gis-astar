<?php

/** Goal: Model for employee changes history auditing, Caller: App\Livewire\Handler\Pegawai\Edit, Deps: Model, Pegawai, User */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PegawaiChangesHistory extends Model
{
    /** @use HasFactory<\Database\Factories\PegawaiChangesHistoryFactory> */
    use HasFactory;

    protected $table = 'tb_pegawai_changes_histories';

    protected $fillable = [
        'pegawai_id',
        'field_name',
        'old_value',
        'new_value',
        'alasan',
        'changed_by',
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id');
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by', 'id');
    }
}
