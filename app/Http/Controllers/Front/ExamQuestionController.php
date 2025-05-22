<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamQuestionController extends Controller
{
    public function index($exam_id)
    {
        $exam = Exam::own()->where('id', $exam_id)->firstOrFail();
        $questions = $exam->questions()->latest()->get();

        return view('front.exam.exam_questions.index', compact('exam', 'questions'));
    }

    public function store(Request $request,  $exam_id)
    {
        $exam = Exam::own()->where('id', $exam_id)->firstOrFail();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'question_type' => 'required|in:1,2,3', // ✅ changed from boolean
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:255',
            'correct_option' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($exam, $validated) {
            $question = $exam->questions()->create([
                'title' => $validated['title'],
                'question_type' => (int) $validated['question_type'],
            ]);

            foreach ($validated['options'] as $index => $optionText) {
                $question->options()->create([
                    'title' => $optionText,
                    'is_correct' => $index === (int)$validated['correct_option'],
                ]);
            }
        });

        return redirect()->route('front.exam_questions.index', $exam->id)
            ->with('success', 'Question added successfully.');
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
    public function edit( ExamQuestion $question, $exam_id)
    {
        $exam = Exam::own()->where('id', $exam_id)->firstOrFail();
        // Ensure the question belongs to the exam
        if ($question->exam_id !== $exam->id) {
            abort(404);
        }

        return view('front.exam.exam_questions.edit', compact('exam', 'question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExamQuestion $question, $exam_id)
    {
        $exam = Exam::own()->where('id', $exam_id)->firstOrFail();
        if ($question->exam_id !== $exam->id) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'question_type' => 'required|in:1,2,3',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:255',
            'correct_option' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($question, $validated) {
            $question->update([
                'title' => $validated['title'],
                'question_type' => (int)$validated['question_type'],
            ]);

            // Delete old options and add new ones
            $question->options()->delete();

            foreach ($validated['options'] as $index => $optionText) {
                $question->options()->create([
                    'title' => $optionText,
                    'is_correct' => $index === (int)$validated['correct_option'],
                ]);
            }
        });

        return redirect()->route('front.exam_questions.index', $exam->id)
            ->with('success', 'Question updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExamQuestion $question, $exam_id)
    {
        $exam = Exam::own()->where('id', $exam_id)->firstOrFail();
        if ($question->exam_id !== $exam->id) {
            abort(404);
        }

        $question->delete();

        return redirect()->route('front.exam_questions.index', $exam->id)
            ->with('success', 'Question deleted successfully.');
    }
}
