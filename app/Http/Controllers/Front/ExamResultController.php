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

}
