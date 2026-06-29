<?php

/** Goal: Represent Attendance Inquiry model for employee requests, Caller: AttendanceInquiry components, Deps: User, Pegawai */

namespace App\Models\AttendanceInquiry;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceInquiry extends Model
{
    use HasFactory;

    protected $table = 'tb_attendance_inquiries';

    protected $fillable = [
        'kode_pegawai',
        'type_absen',
        'position_status',
        'longitude',
        'latitude',
        'waktu_absen',
        'keterangan',
        'no_vt',
        'bukti',
        'status',
        'acted_by',
        'acted_at',
        'rejection_reason',
    ];

    /**
     * Get casts definition.
     */
    protected function casts(): array
    {
        return [
            'waktu_absen' => 'datetime',
            'acted_at' => 'datetime',
            'bukti' => 'array',
        ];
    }

    /**
     * Relationship to the user who processed the approval/rejection.
     */
    public function actedByUser()
    {
        return $this->belongsTo(User::class, 'acted_by');
    }

    /**
     * Get the associated user for the employee code.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'kode_pegawai', 'kode_pegawai');
    }

    /**
     * Accessor for status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => ucfirst($this->status),
        };
    }

    /**
     * Accessor for position status label.
     */
    public function getPositionStatusLabelAttribute(): string
    {
        return match ((int) $this->position_status) {
            1 => 'Dalam Perjalanan',
            2 => 'Standby',
            3 => 'Onsite',
            default => 'Unknown',
        };
    }
}
