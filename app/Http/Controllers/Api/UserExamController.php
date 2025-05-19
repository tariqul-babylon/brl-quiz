<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResource;
use App\Models\Exam;
use Illuminate\Http\Request;

class UserExamController extends Controller
{
    public function show($exam_id)
    {
       try {
        $exam = Exam::where('id', $exam_id)
            ->where('exam_source', 2)
            ->where('exam_status', 2)
            ->first();

        if (!$exam) {
            return response()->json([
                'code' => 404,
                'message' => 'Exam not found',
            ], 404);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Exam found',
            'data' => new ExamResource($exam),
        ], 200);


       } catch (\Exception $e) {    
        return response()->json([
            'code' => 500,
            'message' => $e->getMessage(),
        ], 500);
       }
    }
}
