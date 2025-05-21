<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\AnswerOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Exam;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ExamStartController extends Controller
{
    public function examStart(Request $request)
    {
        Session::put('exam_code', 'EXAM01');
        $exam_code = Session::get('exam_code');
        $exam_token = Session::get('exam_token');

        $exam = Exam::where('exam_code', $exam_code)
            ->where('exam_source', 1)
            ->first();

        if (!$exam) {
            return response()->json([
                'code' => 404,
                'message' => 'Exam not found 2',
            ], 404);
        }

        if ($exam->exam_status != 2) {
            return response()->json([
                'code' => 403,
                'message' => 'Exam is not published. You can not join this exam.',
            ], 403);
        }

        $request['name'] = 'Exam Start';
        $request['contact'] = 'Exam Start';

        $rules = [
            'name' => 'required|string|max:255',
            'contact' => 'required|max:20',
            'id_no' => ['max:100', function ($attribute, $value, $fail) use ($exam) {
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
        try {
            DB::beginTransaction();
            $answer = Answer::create([
                'exam_id' => $exam->id,
                'name' => $request->name,
                'id_no' => $exam->id_no_placeholder ? $request->id_no : null,
                'contact' => $request->contact,
                'join_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                'exam_status' => Answer::JOINED,
                'created_by' => auth()?->user()?->id,
            ]);

            // $add answer id to $answer_options with array map
            $answer_options = array_map(function ($option) use ($answer) {
                $option['answer_id'] = $answer->id;
                return $option;
            }, $answer_options);

            AnswerOption::insert($answer_options);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
        }

        $minute_spent = 0;
        $second_spent = 0;
        $exam_duration = Carbon::createFromFormat('H:i:s', $exam->duration);
        $exam_duration_in_hours = $exam_duration->hour;
        $exam_duration_in_minutes = $exam_duration->minute;

        return view('front.exam.exam-start', compact('exam', 'response_questions', 'exam_duration_in_hours', 'exam_duration_in_minutes', 'minute_spent', 'second_spent'));
    }
}
