<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dayoff extends Model
{
    use HasFactory;
    protected $table = 'tb_dayoff';
    protected $fillable = ['kode_pegawai', 'dayoff_for', 'url', 'tgl_dari', 'tgl_hingga', 'keterangan', 'status', 'notes', 'validate_by'];

    public function pegawaiRelasi()
    {
        return $this->belongsTo(Pegawai::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'validate_by', 'id');
    }
}
