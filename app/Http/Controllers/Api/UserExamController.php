<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResource;
use App\Models\Exam;
use Illuminate\Http\Request;

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
    public function showQuestions(Request $request, $exam_code)
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

        if ($exam->is_question_random) {
            $exam->questions = $exam->questions->random();
        }

        if ($exam->is_option_random) {
            $exam->questions->options = $exam->questions->options->random();
        }
        $questions = [];
        foreach ($exam->questions->random() as $question) {
            $questions[] = [
                'question' => $question->title,
                'options' => $question->options,
            ];
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
}
