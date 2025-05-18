<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Normalize checkbox values from "on" to boolean true/false
        $booleanFields = [
            'is_bluer',
            'is_timer',
            'is_date_enabled',
            'exam_status',
            'user_result_view',
            'user_answer_view',
            'is_question_random',
            'is_option_random',
            'is_sign_in_required',
            'is_specific_student',
            'collect_student_id',
        ];

        $normalized = [];
        foreach ($booleanFields as $field) {
            $normalized[$field] = $this->has($field); // true if "on", false if not present
        }

        $this->merge($normalized);
    }

    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'tagline' => ['required', 'string', 'max:255'],
            'exam_start_time' => ['required', 'date', 'after:now'],
            'exam_end_time' => ['required', 'date', 'after:exam_start_time'],
            'instruction' => ['nullable', 'string'],
            'full_mark' => ['required', 'integer'],
            'negative_mark' => ['nullable', 'numeric', 'min:0'],
            'duration_hours' => 'required|numeric|min:0|max:23',
            'duration_minutes' => 'required|numeric|min:0|max:59',

            // boolean fields
            'is_bluer' => ['sometimes', 'boolean'],
            'is_timer' => ['sometimes', 'boolean'],
            'is_date_enabled' => ['sometimes', 'boolean'],
            'exam_status' => ['sometimes', 'boolean'],
            'user_result_view' => ['sometimes', 'boolean'],
            'user_answer_view' => ['sometimes', 'boolean'],
            'is_question_random' => ['sometimes', 'boolean'],
            'is_option_random' => ['sometimes', 'boolean'],
            'is_sign_in_required' => ['sometimes', 'boolean'],
            'is_specific_student' => ['sometimes', 'boolean'],
            'collect_student_id' => ['sometimes', 'boolean'],


            'id_no_placeholder' => ['required_if:collect_student_id,1', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'exam_link' => ['nullable', 'string', 'max:255'],
        ];
    }
}
