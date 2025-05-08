<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    protected $table = 'tb_options';

    protected $fillable = [
        'id_question',
        'option',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'id_question', 'id');
    }
}
