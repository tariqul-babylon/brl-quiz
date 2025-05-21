<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\AnswerOption;
use App\Models\AnswerOptionChoice;
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

            Session::put('answer_id', $answer->id);
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

        // return $response_questions;
        return view('front.exam.exam-start', compact('exam', 'response_questions', 'exam_duration_in_hours', 'exam_duration_in_minutes', 'minute_spent', 'second_spent'));
    }

    public function  examSubmit(Request $request)  {
        try {
            $submit_at = Carbon::now();
            $answer_id = Session::get('answer_id');
         
            
    
            $answer = Answer::with('exam.questions.options', 'answerOptions')
                ->where('id', $answer_id)
                ->whereHas('exam', function ($query) {
                    $query->where('exam_source', Exam::SOURCE_WEB);
                })
                ->first();
    
            if (!$answer) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Answer not found',
                ], 404);
            }
    
            if ($answer->exam_status == Answer::ENDED) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Answer already submitted.',
                ], 404);
            }

    
            $start_at = Carbon::createFromFormat('Y-m-d H:i:s.u', $answer->join_at);
            $strat_time = Carbon::createFromFormat('Y-m-d H:i:s.u', $answer->join_at);
            $exam_time_duration = Carbon::createFromFormat('H:i:s', $answer->exam->duration);
    
    
    
            $diffInMicroseconds = $start_at->diffInMicroseconds($submit_at);
    
            $hours = floor($diffInMicroseconds / 3600000000); 
            $minutes = floor(($diffInMicroseconds % 3600000000) / 60000000); 
            $seconds = floor(($diffInMicroseconds % 60000000) / 1000000); 
            $microseconds = $diffInMicroseconds % 1000000; 
    
            $duration = sprintf('%02d:%02d:%02d.%06d', $hours, $minutes, $seconds, $microseconds);
    
            $user_time_spent = Carbon::createFromFormat('H:i:s.u', $duration)->addSeconds(10); // 10 second buffering time
            
            if ($user_time_spent->greaterThan($exam_time_duration)) {
                return response()->json([
                    'code' => 404,
                    'message' => 'The allotted time for the exam has expired.',
                ], 404);
            }

    
            $max_end_time = $strat_time->addHours($exam_time_duration->hour)->addMinutes($exam_time_duration->minute)->addSeconds($exam_time_duration->second);
    
            $exam_end_at = $submit_at->format('Y-m-d H:i:s.u');
            
            if  ($submit_at->greaterThan($max_end_time)) {
                $exam_end_at = $max_end_time->format('Y-m-d H:i:s.u');
            }
    
            $exam = $answer->exam;
            $exam_questions = $answer->exam->questions; 
    
            $answer_option_choices = [];
            $correct_answer = 0;
            $incorrect_answer = 0;
            $not_answered = 0;
    
            $mark_per_question = $exam->mark_per_question;
            $full_mark = round($mark_per_question * count($exam_questions));
            $obtained_mark = 0;
            $negative_mark =0;
            $final_obtained_mark = 0;
    
            DB::beginTransaction();

            foreach ($request->except(['_token', '_method']) as $name => $value) {
                if (substr($name, 0, 3) === 'ans' && ctype_digit(substr($name, 3))) {
                    $question_id = substr($name, 3);
                        $option_id = $value;

                        $exam_question = $exam_questions->where('id', $question_id)->first();
                        if (!$exam_question) {
                          continue; 
                        }
        
                        $exam_question_correct_option = $exam_question?->options?->where('is_correct', 1)?->first();
                        
                        $answer_option= $answer->answerOptions->where('question_id', $question_id)->where('answer_status', AnswerOption::NOT_ANSWERED)->first();
                       
                        if (!$answer_option) {
                            continue;
                        }
                        
        
                        if ($exam_question_correct_option?->id == $option_id) {
                            $answer_option->update([
                                'answer_status' => AnswerOption::CORRECT,
                                'answer_at' => Carbon::now()->format('Y-m-d H:i:s.v'),
                            ]);
                            $correct_answer++;
                            $obtained_mark += $mark_per_question;
                        }else{
                            $answer_option->update([
                                'answer_status' => AnswerOption::INCORRECT,
                                'answer_at' => Carbon::now()->format('Y-m-d H:i:s.v'),
                            ]);
                            $incorrect_answer++;
                            $negative_mark += $exam->negative_mark;
                        }
                        
            if ($exam_question->options->where('id', $option_id)->first()) {
                            $answer_option_choices[] = [
                                'answer_option_id' => $answer_option->id,
                                'exam_question_option_id' => $option_id,
                            ];
                        }
                       
                   }

            }
            
            AnswerOptionChoice::insert($answer_option_choices);
    
            $not_answered = $answer->answerOptions->count() - $correct_answer - $incorrect_answer;
           
            $answer->update([
                'correct_ans' => $correct_answer,
                'incorrect_ans' => $incorrect_answer,
                'not_answered' => $not_answered,
                'end_at' => $exam_end_at,
                'duration' => $duration,
                'obtained_mark' => round($obtained_mark,2),
                'negative_mark' => round($negative_mark,2),
                'full_mark' => round($full_mark,2),
                'final_obtained_mark' => round($obtained_mark - $negative_mark,2),
                // 'exam_status' => Answer::ENDED,
                'end_method' => Answer::END_BY_USER,
                'exam_token' => null,
            ]);
           
            
    
            DB::commit();
    
            $response_data = [];
            if ($exam->user_result_view) {
                return view('front.exam.exam-result-overview', compact('exam', 'answer'));
            }

            return view('front.exam.exam-end');

           } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
                'error_line_no' => $e->getLine(),
            ], 500);
           }
        }
}
