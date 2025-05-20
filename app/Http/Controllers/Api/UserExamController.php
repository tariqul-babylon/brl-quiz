<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResource;
use App\Models\Answer;
use App\Models\AnswerOption;
use App\Models\Exam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
    public function startExam(Request $request)
    {
       try {
        $rules = [
            'exam_code' => 'required|string|max:10',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $exam = Exam::with('questions.options')
            ->where('exam_code', $request->exam_code)
            ->where('exam_source', 2)
            ->where('created_by', $request->user()->id)
            ->first();

        if (!$exam) {
            return response()->json([
                'code' => 404,
                'message' => 'Exam not found 2' ,
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
        $answer_options = [];
        $sl_no = 1;
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
            $answer_options[] = [
                'question_id' => $question->id,
                'sl_no' => $sl_no++,
            ];
        }
        $exam_token = $exam->exam_code.'_'.Str::random(150);
        DB::beginTransaction();
        $answer = Answer::create([
            'exam_id' => $exam->id,
            'name' => $request->name,
            'id_no' => $exam->id_no_placeholder ? $request->id_no : null,
            'contact' => $request->contact,
            'join_at' => Carbon::now()->format('Y-m-d H:i:s.v'),
            'exam_status' => Answer::JOINED,
            'exam_token' => $exam_token,
            'created_by' => $request->user()->id,
        ]);

        // $add answer id to $answer_options with array map
        $answer_options = array_map(function ($option) use ($answer) {
            $option['answer_id'] = $answer->id;
            return $option;
        }, $answer_options);

        AnswerOption::insert($answer_options);

        DB::commit();

        return response()->json([
            'code' => 200,
            'message' => 'Exam found',
            'data' => [
                'answer' => [
                    'id' => $answer->id,
                    'name' => $answer->name,
                    'id_no' => $answer->id_no,
                    'contact' => $answer->contact,
                    'join_at' => $answer->join_at,
                    'exam_token' => $answer->exam_token,
                ],
                'exam' => new ExamResource($exam),
                'questions' => $response_questions,
            ],
        ], 200);


       } catch (\Exception $e) {    
        DB::rollBack();
        return response()->json([
            'code' => 500,
            'message' => $e->getMessage(),
        ], 500);
       }
    }

    public function submitExam(Request $request, $exam_code)
    {
       try {

        $rules = [
            'answer_id' => 'required|exists:answers,id',
        ];


        DB::beginTransaction();

        

        

        DB::commit();

        return response()->json([
            'code' => 200,
            'message' => 'Exam submitted successfully',
        ], 200);
       } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'code' => 500,
            'message' => $e->getMessage(),
        ], 500);
       }
    }
}
