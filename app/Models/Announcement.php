<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $table = 'tb_announcements';
    protected $fillable = [
        'title',
        'description',
        'status',
    ];
}
