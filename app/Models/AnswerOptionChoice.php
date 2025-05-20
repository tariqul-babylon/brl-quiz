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
}
