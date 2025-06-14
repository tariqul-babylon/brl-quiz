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
            'question_type' => 'required|in:1,2,3',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:255',
            'correct_option' => 'required|integer|min:0',
        ]);

        // Check if question title is already used in the same exam
        if ($exam->questions()->where('title', $validated['title'])->exists()) {
            return back()->withInput()->withErrors([
                'title' => 'This question title already exists for the selected exam.',
            ]);
        }

        // Check for duplicate options within the same question
        if (count($validated['options']) !== count(array_unique($validated['options']))) {
            return back()->withInput()->withErrors([
                'options' => 'Each option must be unique.',
            ]);
        }

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
    public function edit($exam_id, ExamQuestion $question)
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
    public function update(Request $request, $exam_id, ExamQuestion $question)
    {
        $exam = Exam::own()->where('id', $exam_id)->firstOrFail();
        if ($question->exam_id !== $exam->id) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'question_type' => 'required|in:1,2,3',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:255|distinct',
            'correct_option' => 'required|integer|min:0',
        ], [
            'options.*.distinct' => 'Option values must be unique. Duplicate values are not allowed.',
        ]);

        // Check if question title or type has changed
        $titleChanged = $question->title !== $validated['title'];
        $typeChanged = $question->question_type !== (int)$validated['question_type'];

        // Load existing options
        $existingOptions = $question->options()->orderBy('id')->get();

        // Compare existing options with new options
        $optionsChanged = count($existingOptions) !== count($validated['options']);
        if (!$optionsChanged) {
            foreach ($existingOptions as $index => $option) {
                if (
                    $option->title !== $validated['options'][$index] ||
                    $option->is_correct != ($index === (int)$validated['correct_option'])
                ) {
                    $optionsChanged = true;
                    break;
                }
            }
        }

        // If nothing changed, skip update
        if (!$titleChanged && !$typeChanged && !$optionsChanged) {
            return redirect()->route('front.exam_questions.index', $exam->id)
                ->with('info', 'No changes were made to the question.');
        }

        // Proceed with update
        DB::transaction(function () use ($question, $validated) {
            $question->update([
                'title' => $validated['title'],
                'question_type' => (int)$validated['question_type'],
            ]);

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
    public function destroy($exam_id, ExamQuestion $question)
    {
        $question = ExamQuestion::where('exam_id', $exam_id)
            ->whereHas('exam', function ($query) {
                $query->own();
            })
            ->where('id', $question->id)
            ->firstOrFail();
        $exam = $question->exam;
        $question->delete();

        return redirect()->route('front.exam_questions.index', $exam->id)
            ->with('success', 'Question deleted successfully.');
    }
}
