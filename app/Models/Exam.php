<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use SoftDeletes;
    const DRAFT = 0;
    const PUBLISHED = 1;
    const COMPLETED = 2;



    protected $fillable = [
        'title', 'tagline', 'start_at', 'end_at',
        'instruction', 'full_mark','negative_mark', 'duration',
        'is_bluer', 'is_timer',  'exam_status',
        'user_result_view', 'user_answer_view',
        'is_question_random', 'is_option_random',
        'is_sign_in_required', 'is_specific_student',
        'id_no_placeholder', 'logo', 'exam_link','exam_code'
    ];

    public function questions()
    {
        return $this->hasMany(ExamQuestion::class);
    }

    public function students()
    {
        return $this->hasMany(ExamUser::class)->where('user_type', 2);
    }

    public function authAnswer()
    {
        return $this->hasOne(Answer::class)->where('user_id', auth()->user()->id);
    }
}
