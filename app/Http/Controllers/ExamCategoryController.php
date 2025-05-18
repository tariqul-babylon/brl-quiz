<?php

namespace App\Http\Controllers;

use App\Models\ExamCategory;
use Illuminate\Http\Request;

class ExamCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $examCategories = ExamCategory::with('parent')->latest()->paginate(30);
        return view('admin.exam-categories.index', compact('examCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $examCategories = ExamCategory::whereNull('deleted_at')->get();
        return view('admin.exam-categories.create', compact('examCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'parent_id' => 'nullable|integer',
        ]);

        ExamCategory::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('exam-categories.index')->with('success', 'Exam Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExamCategory $examCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $examCategory = ExamCategory::findOrFail($id);
        $examCategories = ExamCategory::where('id', '!=', $id)
            ->whereNull('deleted_at')
            ->get();

        return view('admin.exam-categories.edit', compact('examCategory', 'examCategories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'parent_id' => 'nullable|integer|exists:exam_categories,id',
        ]);

        $examCategory = ExamCategory::findOrFail($id);
        $examCategory->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('exam-categories.index')->with('success', 'Exam Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExamCategory $examCategory)
    {
        $examCategory->delete();

        return redirect()->route('exam-categories.index')
            ->with('success', 'Exam Category deleted successfully.');
    }
}
