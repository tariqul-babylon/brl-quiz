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
        $session = Session::get('exam_start_data');
        if (!$session) {
            return redirect()->route('front.join-exam');
        }
        $exam_code = $session['exam_code'];
        $name = $session['name'];
        $contact = $session['contact'];
        $id_no = $session['id_no'];

        $exam = Exam::where('exam_code', $exam_code)
            ->where('exam_source', 1)
            ->first();

        if (!$exam) {
            return view('front.exam.exam-alert', ['message' => 'The allotted time for the exam has expired.']);
        } else if ($exam->exam_status != Exam::PUBLISHED) {
            return view('front.exam.exam-alert', ['message' => 'The allotted time for the exam has expired.']);
        } else if ($exam->is_sign_in_required && !auth()->check()) {
            return redirect()->guest(route('login'));
        } else if ($exam?->authAnswer) {
            $now = Carbon::now();
            $join_at = Carbon::parse($exam->authAnswer->join_at);
            $join_at_deration = $join_at->diffInSeconds($now);
            $examDuration = Carbon::parse($exam->duration);
            $exam_duration = $examDuration->hour * 3600 + $examDuration->minute * 60 + $examDuration->second;
            if ($exam?->authAnswer?->exam_stats == Answer::ENDED) {
                return view('front.exam.exam-alert', ['message' => 'You have already finished this exam.']);
            } else if ($join_at_deration > $exam_duration) {
                return view('front.exam.exam-alert', ['message' => 'Exam time is over.']);
            }
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
            //first or create answer
            if (auth()->check()) {
                $answer = Answer::firstOrCreate(
                    [
                        'exam_id' => $exam->id,
                        'user_id' => auth()?->user()?->id,
                    ],
                    [
                        'exam_id' => $exam->id,
                        'user_id' => auth()?->user()?->id,
                        'name' => $name,
                        'id_no' => $exam->id_no_placeholder ? $id_no : null,
                        'contact' => $contact,
                        'join_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                        'exam_status' => Answer::JOINED,
                        'created_by' => auth()?->user()?->id,
                    ]
                );
            } else {
                $answer = Answer::create([
                    'exam_id' => $exam->id,
                    'user_id' => null,
                    'name' => $name,
                    'id_no' => $exam->id_no_placeholder ? $id_no : null,
                    'contact' => $contact,
                    'join_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                    'exam_status' => Answer::JOINED,
                    'created_by' => auth()?->user()?->id,
                ]);
            }
            // $add answer id to $answer_options with array map
            $answer_options = array_map(function ($option) use ($answer) {
                $option['answer_id'] = $answer->id;
                return $option;
            }, $answer_options);

            AnswerOption::upsert($answer_options, ['question_id', 'answer_id']);

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

        //    session exam_start_data update 
        Session::put('exam_start_data', [
            ...Session::get('exam_start_data'),
            'answer_id' => $answer->id,
        ]);


        return view('front.exam.exam-start', compact('exam', 'response_questions', 'exam_duration_in_hours', 'exam_duration_in_minutes', 'minute_spent', 'second_spent'));
    }

    public function  examSubmit(Request $request)
    {
        try {
            $submit_at = Carbon::now();
            $session = Session::get('exam_start_data');
            Session::forget('exam_start_data');
            if (!$session) {
                return redirect()->route('front.join-exam');
            }

            $answer_id = $session['answer_id'];

            $answer = Answer::with('exam.questions.options', 'answerOptions')
                ->where('id', $answer_id)
                ->whereHas('exam', function ($query) {
                    $query->where('exam_source', Exam::SOURCE_WEB);
                })
                ->first();

            if (!$answer) {
                return view('front.exam.exam-alert', ['message' => 'Exam start information not found']);
            }

            if ($answer->exam_status == Answer::ENDED) {
                return view('front.exam.exam-alert', ['message' => 'Answer already submitted.']);
            }

            if (!$answer->exam) {
                return view('front.exam.exam-alert', ['message' => 'The allotted time for the exam has expired.']);
            } else if ($answer->exam->exam_status != Exam::PUBLISHED) {
                return view('front.exam.exam-alert', ['message' => 'The allotted time for the exam has expired.']);
            } else if ($answer->exam->is_sign_in_required && !auth()->check()) {
                return redirect()->guest(route('login'));
            } else if ($answer->exam?->authAnswer) {
                $now = Carbon::now();
                $join_at = Carbon::parse($answer->exam->authAnswer->join_at);
                $join_at_deration = $join_at->diffInSeconds($now);
                $examDuration = Carbon::parse($answer->exam->duration);
                $exam_duration = $examDuration->hour * 3600 + $examDuration->minute * 60 + $examDuration->second;
                if ($answer->exam?->authAnswer?->exam_stats == Answer::ENDED) {
                    return view('front.exam.exam-alert', ['message' => 'You have already finished this exam.']);
                }
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
                return view('front.exam.exam-alert', ['message' => 'The allotted time for the exam has expired.']);
            }


            $max_end_time = $strat_time->addHours($exam_time_duration->hour)->addMinutes($exam_time_duration->minute)->addSeconds($exam_time_duration->second);

            $exam_end_at = $submit_at->format('Y-m-d H:i:s.u');

            if ($submit_at->greaterThan($max_end_time)) {
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
            $negative_mark = 0;
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

                    $answer_option = $answer->answerOptions->where('question_id', $question_id)->where('answer_status', AnswerOption::NOT_ANSWERED)->first();

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
                    } else {
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


            AnswerOptionChoice::upsert(
                $answer_option_choices,
                ['answer_option_id', 'exam_question_option_id'],
            );

            $not_answered = $answer->answerOptions->count() - $correct_answer - $incorrect_answer;

            $answer->update([
                'correct_ans' => $correct_answer,
                'incorrect_ans' => $incorrect_answer,
                'not_answered' => $not_answered,
                'end_at' => $exam_end_at,
                'duration' => $duration,
                'obtained_mark' => round($obtained_mark, 2),
                'negative_mark' => round($negative_mark, 2),
                'full_mark' => round($full_mark, 2),
                'final_obtained_mark' => round($obtained_mark - $negative_mark, 2),
                'exam_status' => Answer::ENDED,
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

    public function examAlert(Request $request)
    {
        return view('front.exam.exam-alert');
    }
}
