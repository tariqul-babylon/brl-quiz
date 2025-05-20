<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    const JOINED = 1;
    const ENDED = 2;

    const END_BY_USER = 1;
    const END_BY_AUTO_SUBMIT = 2;
    const END_BY_TIME = 3;

    protected $fillable = [
        'exam_id',
        'user_id',
        'name',
        'id_no',
        'contact',
        'join_at',
        'end_at',
        'duration',
        'correct_ans',
        'incorrect_ans',
        'not_answered',
        'end_method',
        'exam_token',
        'exam_status',
        'created_by',
        'updated_by',
    ];
    
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
    public function answerOptions()
    {
        return $this->hasMany(AnswerOption::class);
    }
}
