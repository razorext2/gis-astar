<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'tb_jabatan';

    protected $fillable = [
        'nama_jabatan',
        'divisi',
        'penempatan',
        'supervisor_id',
    ];

    public function divisionRelasi()
    {
        return $this->belongsTo(Division::class, 'divisi', 'id');
    }

    public function placementRelasi()
    {
        return $this->belongsTo(Placement::class, 'penempatan', 'id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'jabatan', 'id');
    }
}
