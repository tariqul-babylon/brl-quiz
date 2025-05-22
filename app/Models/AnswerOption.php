<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnswerOption extends Model
{
    const NOT_ANSWERED = 1;
    const CORRECT = 2;
    const INCORRECT = 3;

    public  $timestamps = false;



    protected $fillable = [
        'answer_id',
        'question_id',
        'sl_no',
        'answer_status',
        'answer_at',
    ];

    public function question()
    {
        return $this->belongsTo(ExamQuestion::class, 'question_id');
    }

    public function answerOptionChoices()
    {
        return $this->hasMany(AnswerOptionChoice::class, 'answer_option_id');
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}
