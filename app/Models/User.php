<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\LeaveRequest\LeaveBalance;
use App\Models\LeaveRequest\LeaveRequest;
use App\Models\LeaveRequest\LeaveRequestHistory;
use Creagia\LaravelSignPad\Concerns\RequiresSignature;
use Creagia\LaravelSignPad\Contracts\CanBeSigned;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements CanBeSigned
{
    use HasApiTokens, HasFactory, HasPushSubscriptions, HasRoles, Notifiable, RequiresSignature, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_pegawai',
        'name',
        'email',
        'password',
        'last_login',
        'is_active',
        'deactivation_at',
        'deactivation_reason',
        'profile_pic',
        'deleted_by',
        'join_date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'join_date' => 'date',
        ];
    }

    public function logs(): HasMany
    {
        return $this->hasMany(LogHistory::class, 'user_id', 'id');
    }

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function teamMember(): HasOne
    {
        return $this->hasOne(TeamMember::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function technicianPoint(): HasMany
    {
        return $this->hasMany(TechnicianPoints::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function deletedBy()
    {
        return $this->belongsTo(Pegawai::class, 'deleted_by', 'kode_pegawai');
    }

    // aksesor routing persetujuan cuti
    public function getDirectSupervisorAttribute()
    {
        return $this->pegawai->jabatanRelasi && $this->pegawai->jabatanRelasi->supervisor_id ?
        self::find($this->pegawai->jabatanRelasi->supervisor_id) : null;
    }

    public function getBranchManagerAttribute()
    {
        return $this->pegawai->jabatanRelasi->placementRelasi && $this->pegawai->jabatanRelasi->placementRelasi->manager_id ?
        self::find($this->pegawai->jabatanRelasi->placementRelasi->manager_id) : null;
    }

    // relasi pengajuan cuti
    public function leaveBalances()
    {
        return $this->hasMany(LeaveBalance::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function backedUpLeaves()
    {
        return $this->hasMany(LeaveRequest::class, 'backup_person_id');
    }

    public function performedActions()
    {
        return $this->hasMany(LeaveRequestHistory::class, 'acted_by');
    }

    public function currentLeave(): HasOne
    {
        return $this->hasOne(LeaveRequest::class)
            ->where('status', 'approved')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now());
    }

    // --- Leave Helpers ---

    /**
     * Mendapatkan sisa kuota cuti tahunan berjalan.
     */
    public function currentLeaveBalance()
    {
        return $this->leaveBalances()->where('year', date('Y'))->first();
    }

    /**
     * Menghitung total hari yang sudah digunakan untuk tipe cuti tertentu.
     *
     * @param  string  $leaveCode  (khusus, tahunan, dll)
     */
    public function getLeaveUsageCount(string $leaveCode): int
    {
        return (int) $this->leaveRequests()
            ->whereHas('leaveType', fn ($q) => $q->where('code', $leaveCode))
            ->whereNotIn('status', ['rejected', 'auto_reject', 'canceled'])
            ->sum('total_days');
    }

    /**
     * Cek apakah sudah pernah mengambil cuti khusus (biasanya sekali seumur hidup/periode tertentu).
     */
    public function hasTakenSpecialLeave(string $leaveCode): bool
    {
        return $this->leaveRequests()
            ->whereHas('leaveType', fn ($q) => $q->where('code', $leaveCode))
            ->whereNotIn('status', ['rejected', 'auto_reject', 'canceled'])
            ->exists();
    }
}
