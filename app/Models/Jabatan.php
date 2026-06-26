<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/** Goal: Represent Jabatan model with multiple supervisors, Caller: Models, Deps: User, Pegawai, Division, Placement */

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'tb_jabatan';

    protected $fillable = [
        'nama_jabatan',
        'divisi',
        'penempatan',
    ];

    public function divisionRelasi()
    {
        return $this->belongsTo(Division::class, 'divisi', 'id');
    }

    public function placementRelasi()
    {
        return $this->belongsTo(Placement::class, 'penempatan', 'id');
    }

    public function supervisors()
    {
        return $this->belongsToMany(User::class, 'jabatan_supervisors', 'jabatan_id', 'user_id')->withTimestamps();
    }

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'jabatan', 'id');
    }
}
