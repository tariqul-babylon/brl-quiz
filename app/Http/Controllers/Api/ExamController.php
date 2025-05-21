<?php

namespace App\Http\Controllers\Api;

use App\ExamHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExamRequest;
use App\Models\Exam;
use App\Http\Resources\ExamResource;
use App\Http\Resources\ExamViewResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    use ExamHelper;

    public function index(Request $request)
    {
        try {
            $per_page = $request->input('per_page', 15) > 100 ? 100 : $request->input('per_page', 15);
            //get user with sanctum token


            $exams = Exam::withCount([
                'participants as total_joined',
                'participants as total_ended' => function ($query) {
                    $query->where('exam_status', 2);
                }
            ])
                ->when($request->search)
                ->where(function ($query) use ($request) {
                    $query->where('title', 'like', "%{$request->search}%");
                    $query->orWhere('tagline', 'like', "%{$request->search}%");
                })
                ->when($request->exam_status, function ($query) use ($request) {
                    $query->where('exam_status', $request->exam_status);
                })
                ->where('exam_source', 2)
                ->where('created_by', $request->user()->id)
                ->latest()
                ->paginate($per_page);

            return response()->json([
                'code' => 200,
                'message' => $exams?->count() > 0 ? 'Data found' : 'No data found',
                'data' => [
                    'exams' => [
                        'data' => ExamResource::collection($exams),
                        'links' => [
                            'self' => route('api.exam.index'),
                            'first' => $exams->url(1),
                            'last' => $exams->url($exams->lastPage()),
                            'prev' => $exams->previousPageUrl(),
                            'next' => $exams->nextPageUrl(),
                        ],
                        'meta' => [
                            'current_page' => $exams->currentPage(),
                            'from' => $exams->firstItem(),
                            'last_page' => $exams->lastPage(),
                            'path' => $exams->url(1),
                            'per_page' => $exams->perPage(),
                            'to' => $exams->lastItem(),
                            'total' => $exams->total(),
                        ],
                    ],
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'title' => 'required|string|max:255',
                'tagline' => 'required|string|max:255',
                'mark_per_question' => 'required|numeric|min:0',
                'negative_mark' => 'nullable|numeric|min:0',
                'duration' => 'required|date_format:H:i:s',
                'id_no_placeholder' => 'nullable|string|max:255',
                'exam_status' => 'required|in:1,2,3',

                'is_question_random' => 'nullable|in:0,1',
                'is_question_random' => 'nullable|in:0,1',
                'user_result_view' => 'nullable|in:0,1',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'code' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
           

            // create by validated data 
            $exam = Exam::create([
                ...$validator->validated(),
                'exam_code' =>  $this->makeExamCode(),
                'exam_source' => 2,
                'created_by' => $request->user()->id,
            ]);

            return response()->json([
                'code' => 200,
                'message' => 'Exam created successfully',
                'data' => new ExamResource($exam),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }

    //show exam
    public function show(Request $request, $id)
    {
        try {
            $exam = Exam::with('questions.options')
            ->where('exam_source', 2)
            ->where('created_by', $request->user()->id)
            ->where('id', $id)
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
                'data' => new ExamViewResource($exam),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }

    //update exam
    public function update(Request $request, $id)
    {
        try {
            $rules = [
                'title' => 'required|string|max:255',
                'tagline' => 'required|string|max:255',
                'mark_per_question' => 'required|integer|min:0',
                'negative_mark' => 'nullable|numeric|min:0',
                'duration' => 'required|date_format:H:i:s',
                'id_no_placeholder' => 'nullable|string|max:255',
                'exam_status' => 'required|in:1,2,3',

                'is_question_random' => 'nullable|in:0,1',
                'is_option_random' => 'nullable|in:0,1',
                'user_result_view' => 'nullable|in:0,1',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'code' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
           
            $exam = Exam::where('id', $id)
                ->where('created_by', $request->user()->id)
                ->where('exam_source', 2)
                ->first();
            if (!$exam) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Exam not found',
                ], 404);
            }

            // if($exam->exam_status != 1){
            //     return response()->json([
            //         'code' => 403,
            //         'message' => 'Exam is not in draft status. You can not update this exam.',
            //     ], 403);
            // }

            $exam->update([
                ...$validator->validated(),
                'updated_by' => $request->user()->id,
            ]);

            return response()->json([
                'code' => 200,
                'message' => 'Exam updated successfully',
                'data' => new ExamResource($exam),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function updateStatus(Request $request, $exam_id)
    {
        try {
            $rules = [
                'status' => 'required|in:1,2,3',
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
                ->where('exam_source', 2)
                ->where('created_by', $request->user()->id)
                ->first();

            if (!$exam) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Exam not found',
                ], 404);
            }


            if ($exam->exam_status != 1 && $request->status == 2) {
                return response()->json([
                    'code' => 403,
                    'message' => 'Exam is not in draft status. You can not update this exam.',
                ], 403);
            }

            if ($exam->exam_status != 2 && $request->status == 3) {
                return response()->json([
                    'code' => 403,
                    'message' => 'Exam not published yet. You can not update completed status before exam publish.',
                ], 403);
            }

            $exam->update([
                'exam_status' => $request->status,
            ]);

            return response()->json([
                'code' => 200,
                'message' => 'Exam status updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    //delete exam
    public function destroy(Request $request, $id)
    {
        try {
            $exam = Exam::where('id', $id)
                ->where('created_by', $request->user()->id)
                ->where('exam_source', 2)
                ->first();
            if (!$exam) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Exam not found',
                ], 404);
            }

            if($exam->exam_status != 1){
                return response()->json([
                    'code' => 403,
                    'message' => 'Exam is not in draft status. You can not delete this exam.',
                ], 403);
            }

            DB::transaction(function () use ($exam) {
                $exam->questions->each(function ($question) {
                    $question->options()->delete();
                });
                $exam->questions()->delete();
                $exam->delete();
            });

            return response()->json([
                'code' => 200,
                'message' => 'Exam deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
