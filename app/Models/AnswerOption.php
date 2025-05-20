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
}
