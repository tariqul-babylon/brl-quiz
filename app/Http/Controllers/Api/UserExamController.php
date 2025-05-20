<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnswerResource;
use App\Http\Resources\ExamResource;
use App\Models\Answer;
use App\Models\AnswerOption;
use App\Models\AnswerOptionChoice;
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
            'join_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
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

    public function submitExam(Request $request)
    {
       try {
        $submit_at = Carbon::now();
        $rules = [
            'answer_id' => 'required',
            'exam_token' => 'required|string|max:200',
            'answers' => 'nullable|array',
            'answers.*.question_id' => 'required|numeric',
            'answers.*.exam_question_option_ids' => 'required|array',
            'answers.*.exam_question_option_ids.*' => 'numeric',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $answer = Answer::with('exam.questions.options', 'answerOptions')
            ->where('id', $request->answer_id)
            ->whereHas('exam', function ($query) use ($request) {
                $query->where('exam_source', Exam::SOURCE_API);
                $query->where('created_by', $request->user()->id);  
            })
            ->first();

        if (!$answer) {
            return response()->json([
                'code' => 404,
                'message' => 'Answer not found',
            ], 404);
        }

        if (!$answer->exam_token) {
            return response()->json([
                'code' => 404,
                'message' => 'Exam token expired.',
            ], 404);
        }

        if ($answer->exam_token != $request->exam_token) {
            return response()->json([
                'code' => 404,
                'message' => 'Exam token not matched.',
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

        if ($exam_time_duration->greaterThan($user_time_spent)) {
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
        if (count($request->answers)) {
           foreach (array_unique($request->answers, SORT_REGULAR) as $user_answer) {
                $question_id = $user_answer['question_id'];
                $exam_question_option_ids = array_values(array_unique($user_answer['exam_question_option_ids'], SORT_REGULAR));
                
                $exam_question = $exam_questions->where('id', $question_id)->first();
                if (!$exam_question) {
                  continue; 
                }

                $exam_question_correct_options =array_unique( $exam_question?->options?->where('is_correct', 1)?->pluck('id')->toArray(), SORT_REGULAR);
                
                $answer_option= $answer->answerOptions->where('question_id', $question_id)->where('answer_status', AnswerOption::NOT_ANSWERED)->first();
                if (!$answer_option) {
                    continue;
                }

                if ($exam_question_correct_options == $exam_question_option_ids) {
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

                
                foreach ($exam_question_option_ids as $key => $exam_question_option_id) {
                    $answer_option_choices[] = [
                        'answer_option_id' => $answer_option->id,
                        'exam_question_option_id' => $exam_question_option_id,
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
            'exam_status' => Answer::ENDED,
            'end_method' => Answer::END_BY_USER,
            'exam_token' => null,
        ]);
       
        $response_data = [];
        if ($exam->user_result_view) {
           $response_data = [
            'exam' => new ExamResource($exam),
            'answer' => new AnswerResource($answer),
           ];
        }

        DB::commit();

        return response()->json([
            'code' => 200,
            'message' => 'Exam submitted successfully',
            'data' =>$response_data,
        ], 200);
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
