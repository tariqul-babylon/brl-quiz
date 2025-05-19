<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamQuestionOption extends Model
{
    protected $fillable = ['question_id', 'title', 'is_correct', 'created_by', 'updated_by'];

    public function question()
    {
        return $this->belongsTo(ExamQuestion::class, 'question_id');
    }
}
