<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Exam;
use Carbon\Carbon;
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
      'exam_code' => ['required'],
    ]);

    $exam = Exam::where('exam_code', $request->exam_code)->first();
    $now = Carbon::now();
    if (!$exam) {
      return back()->withErrors(['exam_code' => 'Invalid exam code'])->withInput();
    }
    else if ($exam->exam_status != Exam::PUBLISHED) {
      return back()->withErrors(['exam_code' => 'Exam not available'])->withInput();
    }
    else if ($exam->start_at > $now) {
      return back()->withErrors(['exam_code' => 'Exam not started yet.'])->withInput();
    }
    else if ($exam->end_at < $now) {
      return back()->withErrors(['exam_code' => 'Exam time is over.'])->withInput();
    } else if($exam->is_sign_in_required && !auth()->check()){
      return redirect()->guest(route('login'));
    } 
    else if ($exam?->authAnswer) {
      $now = Carbon::now();
      $join_at = Carbon::parse($exam->authAnswer->join_at);
      $join_at_deration = $join_at->diffInSeconds($now);
      $examDuration = Carbon::parse($exam->duration);
      $exam_duration = $examDuration->hour * 3600 + $examDuration->minute * 60 + $examDuration->second;
      
      if($exam?->authAnswer?->exam_stats == Answer::ENDED){
        return back()->withErrors(['exam_code' => 'You have already finished this exam.'])->withInput();
      }
      else if($join_at_deration > $exam_duration){
        $exam?->authAnswer->update([
          'exam_stats' => Answer::ENDED,
          'end_method' => Answer::END_BY_TIME,
        ]);
        return back()->withErrors(['exam_code' => 'Exam time is over.'])->withInput();
      }
      else if($exam->is_specific_student && !$exam->students->contains('user_id', auth()->user()->id)){
        return back()->withErrors(['exam_code' => 'You are not allowed to join this exam.'])->withInput();
      }
    }
    
    


    // return redirect()->route('front.exam-form', $exam->exam_code);
  }
}
