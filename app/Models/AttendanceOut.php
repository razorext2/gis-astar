<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceOut extends Model
{
    use HasFactory, SoftDeletes;

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
        'keterangan',
    ];

    protected $casts = [
        'jam_keluar' => 'datetime',
    ];

    // In Attendance.php (Model)
    public function pegawaiRelasi()
    {
        return $this->belongsTo(Pegawai::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by', 'id');
    }

    public function scopeNotVerified($query)
    {
        return $query->where('verified', 0)
            ->where('status', 0);
    }
}
