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
}
