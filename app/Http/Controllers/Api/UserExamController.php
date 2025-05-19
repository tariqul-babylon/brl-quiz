<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResource;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserExamController extends Controller
{
    public function show(Request $request, $exam_code)
    {
       try {
        $exam = Exam::where('exam_code', $exam_code)
            ->where('exam_source', 2)
            ->where('created_by', $request->user()->id)
            ->first();

        if (!$exam) {
            return response()->json([
                'code' => 404,
                'message' => 'Exam not found',
            ], 404);
        }

        if ($exam->exam_status != 2) {
            return response()->json([
                'code' => 403,
                'message' => 'Exam is not published. You can not join this exam.',
            ], 403);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Exam found',
            'data' => $exam,
        ], 200);


       } catch (\Exception $e) {    
        return response()->json([
            'code' => 500,
            'message' => $e->getMessage(),
        ], 500);
       }
    }
    public function startExam(Request $request, $exam_code)
    {
       try {

        

        $exam = Exam::with('questions.options')
            ->where('exam_code', $exam_code)
            ->where('exam_source', 2)
            ->where('created_by', $request->user()->id)
            ->first();

        if (!$exam) {
            return response()->json([
                'code' => 404,
                'message' => 'Exam not found',
            ], 404);
        }

        if ($exam->exam_status != 2) {
            return response()->json([
                'code' => 403,
                'message' => 'Exam is not published. You can not join this exam.',
            ], 403);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'contact' => 'required|max:20',
            'id_no' => ['max:100',function ($attribute, $value, $fail) use ($exam) {
                if ($exam->id_no_placeholder && !$value) {
                    $fail('ID number is required.');
                }
            }],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
       
        $response_questions = [];
        $input_questions = $exam->questions;
        if ($exam->is_question_random) {
            $input_questions = $input_questions->shuffle();
        }

        foreach ($input_questions as $question) {
            $options = $question->options;
            if ($exam->is_option_random) {
                $options = $options->shuffle();
            }

            $response_options = [];
            foreach ($options as $option) {
                $response_options[] = [
                    'id' => $option->id,
                    'title' => $option->title,
                ];
            }
            $response_questions[] = [
                'id' => $question->id,
                'question' => $question->title,
                'options' => $response_options,
            ];
        }

        return response()->json([
            'code' => 200,
            'message' => 'Exam found',
            'data' => [
                'exam' => new ExamResource($exam),
                'questions' => $response_questions,
            ],
        ], 200);


       } catch (\Exception $e) {    
        return response()->json([
            'code' => 500,
            'message' => $e->getMessage(),
        ], 500);
       }
    }
}
