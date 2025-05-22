<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnswerResource;
use App\Http\Resources\ExamResource;
use App\Models\Answer;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamResultController extends Controller
{
    public function showResult(Request $request, $exam_id)
    {
       try {

        $exam = Exam::with([])
            ->where('id', $exam_id)
            ->where('exam_status', '<>', Exam::DRAFT)
            ->where('exam_source', Exam::SOURCE_API)
            ->where('created_by', $request->user()->id)
            ->first();

        if (!$exam) {
            return response()->json([
                'code' => 404,
                'message' => 'Exam not found',
            ], 404);
        }

        $answers = Answer::with([])
            ->where('exam_id', $exam_id)
            ->get();

        return response()->json([
            'code' => 200,
            'message' => 'Data found',
            'data' => [
                'exam' => new ExamResource($exam),
                'answers' => AnswerResource::collection($answers),
            ],
        ], 200);
        
       } catch (\Exception $e) {
        return response()->json([
            'code' => 500,
            'message' => $e->getMessage(),
        ], 500);
       }
    }

    public function showResultDetail(Request $request, $answer_id) {
        try {
            $answer = Answer::with([])
            ->whereHas('exam', function ($query) use ($request) {
                $query->where('exam_source', Exam::SOURCE_API)
                ->where('created_by', $request->user()->id);
            })
            ->where('id', $answer_id)
                ->first();

            if (!$answer) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Answer not found',
                ], 404);
            }

            $questions = [];

            foreach ($answer->answerOptions as $answer_option) {
                $questions[] = [
                    'question_id' => $answer_option->question_id,
                    'answer_status' => $answer_option->answer_status,
                    'question'=> [
                        'title' => $answer_option->question->title,
                        'user_answer_options' => $answer_option->answerOptionChoices,
                        'options' => $answer_option->question->options->select('id', 'title', 'is_correct'),
                    ]
                ];
            }

            return response()->json([
                'code' => 200,
                'message' => 'Data found',
                'data' => [
                    'exam' => new ExamResource($answer->exam),
                    'answer' => new AnswerResource($answer),
                    'questions' => $questions,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function showWinners(Request $request, $exam_id, $take = null) {
        try {
            $exam = Exam::query()
                ->where('exam_source', Exam::SOURCE_API)
                ->where('created_by', $request->user()->id)
                ->where('id', $exam_id)
                ->first();

            if (!$exam) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Exam not found',
                ], 404);
            }

            $winners = $exam->winners($take)->get();

            return response()->json([
                'code' => 200,
                'message' => 'Data found',
                'data' => [
                    'winners' => AnswerResource::collection($winners),
                    'exam' => new ExamResource($exam),
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
