<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BigEventParticipant extends Model
{
    use HasUlids, SoftDeletes;

    protected $table = 'tb_big_event_participant';
    protected $fillable = [
        'big_event_id',
        'user_id',
        'visitor_api',
        'redirect_to',
    ];

    public function userId()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bigEventId()
    {
        return $this->belongsTo(BigEvent::class, 'big_event_id');
    }

    public function bigEventVisitor()
    {
        return $this->hasMany(BigEventParticipantVisitor::class, 'participant_id');
    }
}
