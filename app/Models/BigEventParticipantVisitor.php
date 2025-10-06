<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BigEventParticipantVisitor extends Model
{
    use HasUlids, SoftDeletes;

    protected $table = "tb_big_event_participant_visitor";
    protected $fillable = [
        'participant_id',
        'ip',
        'ua',
        'second_bucket',
    ];

    public function participant()
    {
        return $this->belongsTo(BigEventParticipant::class, 'participant_id');
    }
}
