<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    protected $table = 'tb_answers';
    protected $fillable = [
        'kode_pegawai',
        'id_session',
        'id_question',
        'id_option',
    ];

    public function pegawai()
    {
        return $this->belongsTo(User::class, 'kode_pegawai', 'id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'id_question', 'id');
    }

    public function option()
    {
        return $this->belongsTo(QuestionOption::class, 'id_option', 'id');
    }

    public function sales()
    {
        return $this->belongsTo(Sales::class, 'id_session', 'id_session');
    }
}
