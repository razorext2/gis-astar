<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'tb_teams';
    protected $fillable = [
        'team_code',
        'team_name',
        'team_position',
        'team_leader'
    ];

    public function leader()
    {
        return $this->belongsTo(User::class, 'team_leader', 'kode_pegawai');
    }
}
