<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnswerOptionChoice extends Model
{
    public  $timestamps = false;

    protected $fillable = [
        'answer_option_id',
        'exam_question_option_id',
    ];


    public function answerOption()
    {
        return $this->belongsTo(AnswerOption::class, 'answer_option_id');
    }

    public function examQuestionOption()
    {
        return $this->belongsTo(ExamQuestionOption::class, 'exam_question_option_id');
    }

}
