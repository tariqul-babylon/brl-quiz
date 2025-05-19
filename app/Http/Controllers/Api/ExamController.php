<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExamRequest;
use App\Models\Exam;
use App\Http\Resources\ExamResource;
use Illuminate\Http\Request;

class ExamController extends Controller
{
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

    
}
