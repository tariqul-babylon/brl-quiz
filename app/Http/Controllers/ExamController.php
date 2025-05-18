<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamRequest;
use App\Models\Exam;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exams = Exam::latest()->paginate(10);
        return view('admin.exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.exams.create');
    }

    public function store(ExamRequest $request)
    {
        $data = $request->validated();

        // Handle file upload
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('uploads/exam/logo', 'public');
        }

        // Parse datetime if needed
        $data['exam_start_time'] = Carbon::parse($request->input('exam_start_time'))->format('Y-m-d H:i:s');
        $data['exam_end_time'] = Carbon::parse($request->input('exam_end_time'))->format('Y-m-d H:i:s');

        // Duration handling remains the same
        $hours = max(0, (int) $request->input('duration_hours', 0));
        $minutes = max(0, (int) $request->input('duration_minutes', 0));
        $totalSeconds = ($hours * 3600) + ($minutes * 60);
        $data['duration'] = gmdate("H:i:s", $totalSeconds);

        Exam::create($data);

        return redirect()->route('exams.index')->with('success', 'Exam created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        return view('admin.exams.edit', compact('exam'));
    }

    public function update(ExamRequest $request, Exam $exam)
    {
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

        $exam->update($data);

        return redirect()->route('exams.index')->with('success', 'Exam updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('exams.index')->with('success', 'Exam deleted successfully.');
    }

    protected function getBooleanFields()
    {
        return [
            'is_bluer', 'is_timer', 'is_date_enabled',
            'exam_status', 'user_result_view', 'user_answer_view',
            'is_question_random', 'is_option_random',
            'is_sign_in_required', 'is_specific_student',
        ];
    }

    private function parseDuration($input)
    {
        // Default to 0
        $totalSeconds = 0;

        // Match "1 hr 20 min", "2h 30m", "90m", "45s"
        preg_match_all('/(\d+)\s*(h(?:r|ours?)?|m(?:in(?:utes?)?)?|s(?:ec(?:onds?)?)?)/i', $input, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $value = (int)$match[1];
            $unit = strtolower($match[2]);

            if (str_starts_with($unit, 'h')) {
                $totalSeconds += $value * 3600;
            } elseif (str_starts_with($unit, 'm')) {
                $totalSeconds += $value * 60;
            } elseif (str_starts_with($unit, 's')) {
                $totalSeconds += $value;
            }
        }

        return gmdate("H:i:s", $totalSeconds); // store as HH:MM:SS format
    }
}
