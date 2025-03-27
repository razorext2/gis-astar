<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'tb_pegawai';
    protected $fillable = [
        'id',
        'kode_pegawai',
        'nik_pegawai',
        'full_name',
        'nick_name',
        'no_telp',
        'alamat',
        'jabatan',
        'golongan',
        'tgl_lahir',
        'gender',
        'bio'
    ];

    public function collectorReportRelasi()
    {
        return $this->hasMany(Collector::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function userRelasi()
    {
        return $this->belongsTo(User::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function attendanceRelasi()
    {
        return $this->hasMany(Attendance::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function attendanceOutRelasi()
    {
        return $this->hasMany(AttendanceOut::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function latestAttendanceOutRelasi()
    {
        $today = Carbon::today();

        return $this->hasOne(AttendanceOut::class, 'kode_pegawai', 'kode_pegawai')
            ->whereDate('jam_keluar', $today)
            ->latest('jam_keluar');
    }

    public function jabatanRelasi()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan', 'id');
    }

    public function golonganRelasi()
    {
        return $this->belongsTo(Golongan::class, 'golongan', 'id');
    }

    public function jadwalRelasi()
    {
        return $this->hasManyThrough(Jadwal::class, Golongan::class, 'id', 'id_golongan', 'golongan', 'id');
    }

    public function salaryRelasi()
    {
        return $this->belongsTo(Salary::class, 'salary_id', 'id');
    }

    public function allowanceRelasi()
    {
        return $this->hasMany(Allowance::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function deductionRelasi()
    {
        return $this->hasMany(Deduction::class, 'kode_pegawai', 'kode_pegawai');
    }
}
