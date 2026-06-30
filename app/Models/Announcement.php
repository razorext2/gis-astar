<?php

/** Goal: Announcement model for company-wide announcements, Caller: AnnouncementTable, AnnouncementContainer, Deps: AnnouncementRead */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $table = 'tb_announcements';
    protected $fillable = [
        'title',
        'description',
        'status',
        'file_path',
        'target_type',
        'target_roles',
        'target_users',
    ];

    protected $casts = [
        'target_roles' => 'array',
        'target_users' => 'array',
    ];

    public function reads(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AnnouncementRead::class);
    }

    /**
     * Check if the given user has any unread announcements.
     */
    public static function hasUnreadForUser(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        $roles = $user->roles->pluck('id')->toArray();
        $userId = $user->id;

        return self::where('status', 1)
            ->whereDoesntHave('reads', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where(function ($query) use ($roles, $userId) {
                $query->where('target_type', 'all')
                    ->orWhere(function ($q) use ($roles) {
                        $q->where('target_type', 'role');
                        if (empty($roles)) {
                            $q->whereRaw('1 = 0');
                        } else {
                            $q->where(function ($q2) use ($roles) {
                                foreach ($roles as $role) {
                                    $q2->orWhereJsonContains('target_roles', (int)$role)
                                        ->orWhereJsonContains('target_roles', (string)$role);
                                }
                            });
                        }
                    })
                    ->orWhere(function ($q) use ($userId) {
                        $q->where('target_type', 'user')
                            ->where(function ($sub) use ($userId) {
                                $sub->whereJsonContains('target_users', (int)$userId)
                                    ->orWhereJsonContains('target_users', (string)$userId);
                            });
                    });
            })
            ->exists();
    }
}
