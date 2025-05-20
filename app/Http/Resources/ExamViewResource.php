<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $total_questions = $this->questions?->count() ?? 0;
        return [
            'id' => $this->id,
            'title' => $this->title,
            'tagline' => $this->tagline,
            'negative_mark' => round($this->negative_mark, 2),
            'duration' => $this->duration,
            'mark_per_question' => $this->mark_per_question,
            'exam_status' => $this->exam_status,
            'full_mark' => $this->mark_per_question * $total_questions,
            'total_question' => $total_questions,
            'user_answer_view' => $this->user_answer_view,
            'is_question_random' => $this->is_question_random,
            'is_option_random' => $this->is_option_random,
            'id_no_placeholder' => $this->id_no_placeholder,
            'exam_link' => $this->exam_link,
            'exam_code' => $this->exam_code,
            'total_joined' => $this->total_joined,
            'total_ended' => $this->total_ended,
            'questions' => QuestionResource::collection($this->questions),
        ];
    }
}
