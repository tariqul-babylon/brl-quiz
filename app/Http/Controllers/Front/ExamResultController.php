<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamResultController extends Controller
{
     public function index($id)
    {
        $exam = Exam::where('id',$id)->first();
        $answers = Answer::where('exam_id',$id)->get();
        return view('front.exam.exam-result',compact('exam','answers'));
    }

    public function show($id)
    {
        $answer = Answer::with([
            'exam.questions.options',
            'answerOptions.question', // Add this to eager-load the question
            'answerOptions.answerOptionChoices.examQuestionOption.question'
        ])->findOrFail($id);

        return view('front.exam.exam-result-details', compact('answer'));
    }

}
