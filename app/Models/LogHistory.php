<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_log';
    protected $fillable = ['user_id', 'user_action', 'ip_address', 'user_agent', 'user_location'];

    public function userRelasi()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
