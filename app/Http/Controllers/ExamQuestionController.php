<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class ExamQuestionController extends Controller
{
    public function index(Exam $exam)
    {
        $questions = $exam->questions()->latest()->get();

        return view('admin.exam_questions.index', compact('exam', 'questions'));
    }

    public function store(Request $request, Exam $exam)
    {
        dd($request->all());
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'question_type' => 'required|boolean',
            'status' => 'required|boolean',
        ]);

        $exam->questions()->create($validated);

        return redirect()->route('exam_questions.index', $exam->id)->with('success', 'Question added successfully.');
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
    public function edit(string $id)
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
