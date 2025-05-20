<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnswerOption extends Model
{
    public  $timestamps = false;

    protected $fillable = [
        'answer_id',
        'question_id',
        'sl_no',
        'answer_status',
        'answer_at',
    ]; 
}
