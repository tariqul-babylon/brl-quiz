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
    ];

    // Optional: define relation back to Exam if needed
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
