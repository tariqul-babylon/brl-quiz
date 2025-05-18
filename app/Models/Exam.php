<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'tagline', 'exam_start_time', 'exam_end_time',
        'instruction', 'full_mark','negative_mark', 'duration',
        'is_bluer', 'is_timer', 'is_date_enabled', 'exam_status',
        'user_result_view', 'user_answer_view',
        'is_question_random', 'is_option_random',
        'is_sign_in_required', 'is_specific_student',
        'id_no_placeholder', 'logo', 'exam_link'
    ];


    public function questions()
    {
        return $this->hasMany(ExamQuestion::class);
    }

}
