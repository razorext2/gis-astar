<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'bio',
        'storage',
    ];

    public function userRelasi()
    {
        return $this->belongsTo(User::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function attendanceRelasi()
    {
        $today = Carbon::today();

        return $this->hasOne(Attendance::class, 'kode_pegawai', 'kode_pegawai')
            ->whereDate('jam_masuk', $today)
            ->latest('jam_masuk');
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

    public function salesReport()
    {
        return $this->hasMany(Sales::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function driverReport()
    {
        return $this->hasMany(Driver::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function collectorReport()
    {
        return $this->hasMany(Collector::class, 'kode_pegawai', 'kode_pegawai');
    }
}
