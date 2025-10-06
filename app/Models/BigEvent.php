<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BigEvent extends Model
{
    use SoftDeletes, HasUlids;

    protected $table = 'tb_big_event';
    protected $fillable = [
        'name',
        'description',
        'location',
        'start_date',
        'end_date',
        'status',
    ];
}
