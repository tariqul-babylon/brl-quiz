<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResource;
use App\Http\Resources\QuestionResource;
use App\Models\Exam;
use App\Models\ExamQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ExamQuestionController extends Controller
{
    public function store(Request $request, $exam_id)
    {
        try {
            $rules = [
                // make array 
                'title' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) use ($exam_id) {
                    ExamQuestion::where('title', $value)->where('exam_id', $exam_id)->exists() ? $fail('Question title already exists.') : true;
                }],
                'question_type' => 'required|in:1,2,3',
                'options' => [
                    'required',
                    'array',
                    'min:2', // Minimum 2 options
                    function ($attribute, $value, $fail) use ($request) {
                        $duplicate = collect($request->options)->pluck('title')->duplicates();
                        if ($duplicate->isNotEmpty()) {
                            $fail('Option title must be unique.');
                        }
                        $hasCorrect = collect($value)->contains('is_correct', true);
                        if (!$hasCorrect) {
                            $fail('At least one option must be marked as correct.');
                        }
                    }
                ],
                'options.*.title' => 'required|string|max:255',
                'options.*.is_correct' => 'required|boolean',
            ];

            $messages = [
                'title.required' => 'Question title is required',
                'question_type.required' => 'Question type is required',
                'options.*.title.required' => 'Each option must have a title',
                'options.*.is_correct.required' => 'Each option must specify if it\'s correct',
            ];

            // return $request->all(); 
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'code' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $exam = Exam::where('id', $exam_id)
                ->where('exam_source', 2)
                ->where('created_by', $request->user()->id)
                ->first();

            if (!$exam) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Exam not found',
                ], 404);
            }

            if ($exam->exam_status != 1) {
                return response()->json([
                    'code' => 403,
                    'message' => 'Exam is not in draft status. You can not update this exam.',
                ], 403);
            }

            $exam_question = ExamQuestion::create([
                ...$validator->validated(),
                'exam_id' => $exam_id,
                'created_by' => $request->user()->id,
            ]);

            $exam_question->options()->createMany($validator->validated()['options']);

            return response()->json([
                'code' => 200,
                'message' => 'Exam question created successfully',
                'data' => new QuestionResource($exam_question),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Request $request, $question_id)
    {
        try {
            $exam_question = ExamQuestion::where('id', $question_id)
                ->first();

            if (!$exam_question) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Exam question not found',
                ], 404);
            }

            $exam = Exam::where('id', $exam_question->exam_id)
                ->where('exam_source', 2)
                ->where('created_by', $request->user()->id)
                ->first();

            if (!$exam) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Exam not found',
                ], 404);
            }else if($exam->exam_status != 1){
                return response()->json([
                    'code' => 403,
                    'message' => 'Exam is not in draft status. You can not update this exam.',
                ], 403);
            }

            return response()->json([
                'code' => 200,
                'message' => 'Exam question found',
                'data' => new QuestionResource($exam_question),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $question_id)
    {
        try {

            $exam_question = ExamQuestion::where('id', $question_id)
                ->whereHas('exam', function ($query) use ($request) {
                    $query->where('exam_source', 2);
                    $query->where('created_by', $request->user()->id);
                })
                ->first();

            if (!$exam_question) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Exam question not found',
                ], 404);
            }

            $exam_id = $exam_question->exam_id;

            $rules = [
                'title' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) use ($exam_id, $question_id) {
                    ExamQuestion::where('title', $value)->where('exam_id', $exam_id)->where('id', '!=', $question_id)->exists() ? $fail('Question title already exists.') : true;
                }],
                'question_type' => 'required|in:1,2,3',
                // option title must be unique
                'options' => [
                    'required',
                    'array',
                    'min:2', // Minimum 2 options
                    function ($attribute, $value, $fail) use ($request) {
                        //find duplicate option title
                        $duplicate = collect($request->options)->pluck('title')->duplicates();
                        if ($duplicate->isNotEmpty()) {
                            $fail('Option title must be unique.');
                        }
                        $hasCorrect = collect($value)->contains('is_correct', true);
                        if (!$hasCorrect) {
                            $fail('At least one option must be marked as correct.');
                        }
                    }
                ],
                'options.*.title' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) use ($exam_id, $question_id, $request) {
                    // need find is any duplicate reqution option title exists


                    ExamQuestion::where('title', $value)->where('exam_id', $exam_id)->where('id', '!=', $question_id)->where('exam_id', $request->exam_id)->exists() ? $fail('Option title already exists.') : true;
                }],
                'options.*.is_correct' => 'required|boolean',
            ];

            $messages = [
                'title.required' => 'Question title is required',
                'question_type.required' => 'Question type is required',
                'options.*.title.required' => 'Each option must have a title',
                'options.*.is_correct.required' => 'Each option must specify if it\'s correct',
            ];

            // return $request->all(); 
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'code' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $exam = Exam::where('id', $exam_id)
                ->where('exam_source', 2)
                ->where('created_by', $request->user()->id)
                ->first();

            if (!$exam) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Exam not found',
                ], 404);
            }

            if ($exam->exam_status != 1) {
                return response()->json([
                    'code' => 403,
                    'message' => 'Exam is not in draft status. You can not update this exam.',
                ], 403);
            }



            if (!$exam_question) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Exam question not found',
                ], 404);
            }
            DB::beginTransaction();
            $exam_question->update([
                ...$validator->validated(),
            ]);

            $exam_question->options()->delete();
            $exam_question->options()->createMany($validator->validated()['options']);
            DB::commit();
            return response()->json([
                'code' => 200,
                'message' => 'Exam question updated successfully',
                'data' => new QuestionResource($exam_question),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,  $question_id)
    {
        try {
            DB::beginTransaction();
            $exam_question = ExamQuestion::where('id', $question_id)
                ->whereHas('exam', function ($query) use ($request) {
                    $query->where('created_by', $request->user()->id);
                    $query->where('exam_source', 2);
                })
                ->first();

            if (!$exam_question) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Exam question not found',
                ], 404);
            }
            $exam_question->options()->delete();
            $exam_question->delete();
            DB::commit();
            return response()->json([
                'code' => 200,
                'message' => 'Exam question deleted successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
