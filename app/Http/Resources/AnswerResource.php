<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'exam_id'         => $this->exam_id,
            'user_id'         => $this->user_id,
            'name'            => $this->name,
            'id_no'           => $this->id_no,
            'contact'         => $this->contact,
            'join_at'         => $this->join_at,
            'end_at'          => $this->end_at,
            'duration'        => $this->duration,
            'correct_ans'     => $this->correct_ans,
            'incorrect_ans'   => $this->incorrect_ans,
            'not_answered'    => $this->not_answered,
            'full_mark'       => $this->full_mark,
            'obtained_mark'   => $this->obtained_mark,
            'negative_mark'   => $this->negative_mark,
            'final_obtained_mark'   => $this->final_obtained_mark,
            'end_method'      => $this->end_method,
            'exam_status'     => $this->exam_status,
        ];
    }
}
