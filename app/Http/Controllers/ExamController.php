<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamRequest;
use App\Models\Exam;
use App\Models\ExamUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $data['start_at'] = Carbon::parse($request->input('exam_start_time'))->format('Y-m-d H:i:s');
        $data['end_at'] = Carbon::parse($request->input('exam_end_time'))->format('Y-m-d H:i:s');

        // Duration handling remains the same
        $hours = max(0, (int) $request->input('duration_hours', 0));
        $minutes = max(0, (int) $request->input('duration_minutes', 0));
        $totalSeconds = ($hours * 3600) + ($minutes * 60);
        $data['duration'] = gmdate("H:i:s", $totalSeconds);

        $code = $this->makeExamCode();
        while(1){
            if(!Exam::where('exam_code', $code)->exists()){
                break;
            }
            $code = $this->makeExamCode();
        }

        $data['exam_code'] = $code;

        Exam::create($data);

        return redirect()->route('exams.index')->with('success', 'Exam created successfully.');
    }

    private function makeExamCode($digits=6){
        $characters = "123456789ABCDEF123456789GHJ123456789KMN123456789PQRST123456789UVW123456789XYZ123456789";
        $characters = str_shuffle($characters);
        $code = '';
        for ($i = 0; $i < $digits; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $code;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $exam = Exam::with(['questions.options'])->findOrFail($id);
        return view('admin.exams.show', compact('exam'));
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

    public function createLink(Exam $exam)
    {
        $exam->update([
            'exam_link' => '/exam/'.$exam->exam_code
        ]);

        return redirect()->route('exams.index')->with('success', 'Exam Link Created successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $type = $request->get('type');  // You can still use this for filtering if needed
        $examId = $request->get('exam_id');

        $users = User::where(function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%");
        })
            ->limit(10)
            ->get(['id', 'name', 'email', 'photo']);  // corrected to match your property name

        // Fetch assigned user IDs for this exam (assuming pivot table exam_user with user_id and exam_id)
        $assignedUserIds = [];
        if ($examId) {
            $assignedUserIds = ExamUser::where('exam_id', $examId)
                ->pluck('user_id')
                ->toArray();
        }

        // Map users, add disabled property if assigned
        return $users->map(function ($user) use ($assignedUserIds) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'image' => $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : null,
                'disabled' => in_array($user->id, $assignedUserIds),  // Add this flag
            ];
        });
    }


    // ExamController.php

    public function assignTeacher(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
        ]);

        $examId = $request->query('exam_id');
        $userId = $request->user_id;

        // Check if user is already assigned in conflicting role
        if ($this->hasConflictingAssignment($examId, $userId, 1)) {
            return redirect()->back()->withErrors([
                'user_id' => 'This user is already assigned as a student for this exam, or already assigned as teacher.'
            ]);
        }

        ExamUser::create([
            'user_id' => $userId,
            'exam_id' => $examId,
            'user_type' => 1,
        ]);

        return redirect()->back()->with('success', 'Teacher assigned successfully.');
    }

    public function assignStudent(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
        ]);

        $examId = $request->query('exam_id');
        $userId = $request->user_id;

        // Check if user is already assigned in conflicting role
        if ($this->hasConflictingAssignment($examId, $userId, 2)) {
            return redirect()->back()->withErrors([
                'user_id' => 'This user is already assigned as a teacher for this exam, or already assigned as student.'
            ]);
        }

        ExamUser::create([
            'user_id' => $userId,
            'exam_id' => $examId,
            'user_type' => 2,
        ]);

        return redirect()->back()->with('success', 'Student assigned successfully.');
    }

    private function hasConflictingAssignment($examId, $userId, $currentUserType)
    {
        // The conflicting user_type is the opposite of current one
        $conflictingUserType = $currentUserType === 1 ? 2 : 1;

        // Check if user already assigned as conflicting user_type
        $conflictExists = ExamUser::where('exam_id', $examId)
            ->where('user_id', $userId)
            ->where('user_type', $conflictingUserType)
            ->exists();

        if ($conflictExists) {
            return true;
        }

        // Also check if user already assigned with the current user_type (avoid duplicates)
        $alreadyAssigned = ExamUser::where('exam_id', $examId)
            ->where('user_id', $userId)
            ->where('user_type', $currentUserType)
            ->exists();

        return $alreadyAssigned;
    }
}
