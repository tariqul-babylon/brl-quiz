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
}
