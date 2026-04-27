<?php

/** Goal: Model log perubahan status server, Caller: CheckServerStatus command, Deps: ServerMonitor */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServerMonitorLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'server_monitor_id',
        'status',
        'response_time_ms',
        'note',
        'logged_at',
    ];

    protected $casts = [
        'logged_at' => 'datetime',
    ];

    public function server(): BelongsTo
    {
        return $this->belongsTo(ServerMonitor::class, 'server_monitor_id');
    }
}
