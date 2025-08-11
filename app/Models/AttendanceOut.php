<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceOut extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'tb_attendance_out';

    protected $fillable = [
        'kode_pegawai',
        'upl',
        'upl68',
        'uplm68',
        'upljam',
        'jenis',
        'waktuori',
        'timezone',
        'status',
        'jam_keluar',
        'longitude',
        'latitude',
        'position_status',
        'photoURL',
        'verified',
        'distance',
        'verified_by',
        'keterangan'
    ];

    protected $casts = [
        'jam_keluar' => 'datetime',
    ];

    // In Attendance.php (Model)
    public function pegawaiRelasi()
    {
        return $this->belongsTo(Pegawai::class, 'kode_pegawai', 'kode_pegawai');
    }
}
