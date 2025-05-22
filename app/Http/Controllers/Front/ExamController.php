<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ExamRequest;
use App\Models\Exam;
use App\Models\ExamUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\ExamHelper;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    use ExamHelper;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exams = Exam::with('questions')
        ->own()
        ->latest()
        ->paginate();
        return view('front.exam.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('front.exam.create');
    }

    public function store(ExamRequest $request)
    {
        $data = $request->validated();
        // Handle file upload
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('uploads/exam/logo', 'public');
        }

        // Parse datetime if needed
        $data['start_at'] = Carbon::parse($request->input('exam_start_time'))->format('Y-m-d H:i:s');
        $data['end_at'] = Carbon::parse($request->input('exam_end_time'))->format('Y-m-d H:i:s');

        // Duration handling remains the same
        $hours = max(0, (int) $request->input('duration_hours', 0));
        $minutes = max(0, (int) $request->input('duration_minutes', 0));
        $totalSeconds = ($hours * 3600) + ($minutes * 60);
        $data['duration'] = gmdate("H:i:s", $totalSeconds);

        $code = $this->makeExamCode();
        while (1) {
            if (!Exam::where('exam_code', $code)->exists()) {
                break;
            }
            $code = $this->makeExamCode();
        }

        $data['exam_code'] = $code;
        $data['exam_status'] = 1;

        $data['created_by'] = auth()->user()->id;

        $exam = Exam::create($data);

        return redirect()->route('front.exam_questions.index', $exam->id)->with('success', 'Exam created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $exam = Exam::with(['questions.options'])
        ->own()
        ->findOrFail($id);
        return view('front.exam.show', compact('exam'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $exam = Exam::with(['questions.options'])
        ->own()
        ->findOrFail($id);
        return view('front.exam.edit', compact('exam'));
    }

    public function update(ExamRequest $request,  $id)
    {
        $exam = Exam::with(['questions.options'])
            ->own()
            ->findOrFail($id);
        $data = $request->validated();

        // Handle file upload if a new logo is provided
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('uploads/exam/logo', 'public');
        }

        // Process duration from hours and minutes input
        $hours = (int) $request->input('duration_hours', 0);
        $minutes = (int) $request->input('duration_minutes', 0);
        $totalSeconds = ($hours * 3600) + ($minutes * 60);
        $data['duration'] = gmdate("H:i:s", $totalSeconds); // Store as HH:MM:SS
        $data['updated_by'] = auth()->user()->id;

        if (!$exam->exam_link) {
            $data['exam_link'] = '/exam/' . $exam->exam_code;
        }

        $exam->update($data);

        return redirect()->route('exams.index')->with('success', 'Exam updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $exam = Exam::with(['questions.options'])
            ->own()
            ->findOrFail($id);
        $exam->delete();

        return redirect()->route('exams.index')->with('success', 'Exam deleted successfully.');
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
                ->own()
                ->first();

            if (!$exam) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Exam not found',
                ], 404);
            }


            if (!in_array($exam->exam_status, [1, 3]) && $request->status == 2) {
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
}
