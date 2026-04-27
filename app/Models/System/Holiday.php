<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $table = 'tb_holidays';

    protected $fillable = [
        'date',
        'name',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
