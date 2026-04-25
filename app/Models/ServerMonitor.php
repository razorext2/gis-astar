<?php

/** Goal: Model konfigurasi server monitoring, Caller: ServerOverview, CheckServerStatus, Deps: ServerMonitorLog */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ServerMonitor extends Model
{
    protected $fillable = [
        'name',
        'api_url',
        'is_active',
    ];

    public function logs(): HasMany
    {
        return $this->hasMany(ServerMonitorLog::class);
    }

    public function latestLog(): HasOne
    {
        return $this->hasOne(ServerMonitorLog::class)->latestOfMany('logged_at');
    }
}
