<?php

namespace App\Models;

/** Goal: Represent User model, Caller: Authentication and Relationships, Deps: Spatie Permission, SignPad, LeaveRequest */

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Spk\SpkMain;
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

    public function spks(): HasMany
    {
        return $this->hasMany(SpkMain::class, 'added_by', 'id');
    }
}
