<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExamQuestionController extends Controller
{
    public function store(Request $request, $exam_id)
    {
        try {
            $rules = [
                'title' => 'required',
                'question_type' => 'required',
                'status' => 'required',
            ]; 

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'code' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
            


            $exam = Exam::where('id', $exam_id)
                ->whereHas('exam', function ($query) use ($request) {
                    $query->where('created_by', $request->user()->id);
                    $query->where('exam_source', 2);
                })
                ->first();

            if (!$exam) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Exam not found',
                ], 404);
            }

           
            
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
