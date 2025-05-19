<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    protected $fillable = [
        'exam_id',
        'title',
        'question_type',
        'status',
        'created_by',
        'updated_by',
    ];

    const QUESTION_TYPE = [
        1 => 'MCQ',
        2 => 'True / False',
        3 => 'Yes / No',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function options()
    {
        return $this->hasMany(ExamQuestionOption::class, 'question_id');
    }
}
