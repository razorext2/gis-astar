<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/** Goal: Represent Placement model and remove unused manager_id, Caller: Models, Deps: User */

class Placement extends Model
{
    use HasFactory;

    protected $table = 'tb_placement';

    protected $fillable = [
        'kode_penempatan',
        'penempatan',
        'alamat',
        'longitude',
        'latitude',
        'radius',
        'restrict_app',
    ];

    public function hrds()
    {
        return $this->belongsToMany(User::class, 'placement_hrds', 'placement_id', 'user_id')->withTimestamps();
    }

    public function managements()
    {
        return $this->belongsToMany(User::class, 'placement_managements', 'placement_id', 'user_id')->withTimestamps();
    }
}
