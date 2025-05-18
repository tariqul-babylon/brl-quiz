<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;

class JoinExamController extends Controller
{
  public function joinExam()
  {
    return view('front.exam.join-exam');
  }

  public function joinExamSubmit(Request $request)
  {
    $request->validate([
      'exam_code' => ['required', function ($attribute, $value, $fail) {
        $exam = Exam::where('code', $value)->first();
        if (!$exam) {
          return $fail('Invalid exam code');
        }
      }],
    ]);

    return redirect()->route('front.exam-form', $request->exam_code);
  }
}
