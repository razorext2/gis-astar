<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "tb_questions";
    protected $fillable = [
        'for',
        'is_active',
        'question',
        'added_by'
    ];

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    public function option()
    {
        return $this->hasMany(QuestionOption::class, 'id_question', 'id');
    }
}
