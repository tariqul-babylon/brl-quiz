<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'tagline' => $this->tagline,
            // 'start_at' => $this->start_at,
            // 'end_at' => $this->end_at,
            // 'instruction' => $this->instruction,
            'mark_per_question' => $this->mark_per_question,
            'negative_mark' => round($this->negative_mark, 2),
            'duration' => $this->duration,
            // 'is_bluer' => $this->is_bluer,
            // 'is_timer' => $this->is_timer,
            'exam_status' => $this->exam_status,
            // 'user_result_view' => $this->user_result_view,
            'user_answer_view' => $this->user_answer_view,
            'is_question_random' => $this->is_question_random,
            'is_option_random' => $this->is_option_random,
            // 'is_sign_in_required' => $this->is_sign_in_required,
            // 'is_specific_student' => $this->is_specific_student,
            'id_no_placeholder' => $this->id_no_placeholder,
            'exam_link' => $this->exam_link,
            'exam_code' => $this->exam_code,
            'total_joined' => $this->total_joined,
            'total_ended' => $this->total_ended,
        ];
    }
}
