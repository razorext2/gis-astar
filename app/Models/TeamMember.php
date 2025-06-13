<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $table = 'tb_team_members';
    protected $fillable = [
        'team_code',
        'kode_pegawai',
        'user_id',
        'role',
    ];

    public function userId()
    {
        return $this->belongsTo(User::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_code', 'team_code');
    }
}
