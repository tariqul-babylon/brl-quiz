<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Exam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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

    $exam = Exam::where('exam_code', $request->exam_code)
      ->where('exam_source', Exam::SOURCE_WEB)
      ->first();

    $now = Carbon::now();
    if (!$exam) {
      return back()->withErrors(['exam_code' => 'Invalid exam code'])->withInput();
    } else if ($exam->exam_status != Exam::PUBLISHED) {
      return back()->withErrors(['exam_code' => 'Exam not available'])->withInput();
    } else if ($exam->is_sign_in_required && !auth()->check()) {
      return redirect()->guest(route('login'));
    } else if ($exam?->authAnswer) {
      $now = Carbon::now();
      $join_at = Carbon::parse($exam->authAnswer->join_at);
      $join_at_deration = $join_at->diffInSeconds($now);
      $examDuration = Carbon::parse($exam->duration);
      $exam_duration = $examDuration->hour * 3600 + $examDuration->minute * 60 + $examDuration->second;

      if ($exam?->authAnswer?->exam_status == Answer::ENDED) {
        return back()->withErrors(['exam_code' => 'You have already finished this exam.'])->withInput();
      } else if ($join_at_deration > $exam_duration) {
        return back()->withErrors(['exam_code' => 'Exam time is over.'])->withInput();
      }
    }

    return redirect()->route('front.exam', $exam->exam_code);
  }

  // public function exam($exam_code)
  // {
  //   $exam = Exam::where('exam_code', $exam_code)->first();
  //   return view('front.exam.exam', compact('exam'));
  // }

  public function examForm($exam_code)
  {
    $exam = Exam::where('exam_code', $exam_code)
      ->where('exam_source', Exam::SOURCE_WEB)
      ->first();

    $now = Carbon::now();
    if (!$exam) {
      return view('front.exam.exam-alert', ['message' => 'The allotted time for the exam has expired.']);
    } else if ($exam->exam_status != Exam::PUBLISHED) {
      return view('front.exam.exam-alert', ['message' => 'The allotted time for the exam has expired.']);
    } 
    // else if ($exam->is_sign_in_required && !auth()->check()) {
    //   return redirect()->guest(route('login'));
    // } 
    // else if ($exam?->authAnswer && auth()->check()) {
    //   $now = Carbon::now();
    //   $join_at = Carbon::parse($exam->authAnswer->join_at);
    //   $join_at_deration = $join_at->diffInSeconds($now);
    //   $examDuration = Carbon::parse($exam->duration);
    //   $exam_duration = $examDuration->hour * 3600 + $examDuration->minute * 60 + $examDuration->second;

    //   if ($exam?->authAnswer?->exam_status == Answer::ENDED) {
    //     return view('front.exam.exam-alert', ['message' => 'You have already finished this exam.']);
    //   } else if ($join_at_deration > $exam_duration) {
    //     return view('front.exam.exam-alert', ['message' => 'Exam time is over.']);
    //   }
    // }

    return view('front.exam.exam-form', compact('exam'));
  }

  public function examSubmit(Request $request, $exam_code)
  {
    $exam = Exam::where('exam_code', $request->exam_code)
      ->where('exam_source', Exam::SOURCE_WEB)
      ->first();


    $now = Carbon::now();
    if (!$exam) {
      return view('front.exam.exam-alert', ['message' => 'The allotted time for the exam has expired.']);
    } else if ($exam->exam_status != Exam::PUBLISHED) {
      return view('front.exam.exam-alert', ['message' => 'The allotted time for the exam has expired.']);
    } else if ($exam->is_sign_in_required && !auth()->check()) {
      return redirect()->guest(route('login'));
    } else if ($exam?->authAnswer) {

      $now = Carbon::now();
      $join_at = Carbon::parse($exam->authAnswer->join_at);
      $join_at_deration = $join_at->diffInSeconds($now);
      $examDuration = Carbon::parse($exam->duration);
      $exam_duration = $examDuration->hour * 3600 + $examDuration->minute * 60 + $examDuration->second;
      if ($exam?->authAnswer?->exam_status == Answer::ENDED) {
        return view('front.exam.exam-alert', ['message' => 'You have already finished this exam.']);
      } else if ($join_at_deration > $exam_duration) {
        return view('front.exam.exam-alert', ['message' => 'Exam time is over.']);
      }
    }

    $rules = [
      'name' => 'required|string|max:150',
      'contact' => 'required|string|max:20',
    ];
    if ($exam->id_no_placeholder) {
      $rules['id_no'] = 'required|string|max:100';
    }

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return redirect()->route('front.exam', $exam->exam_code)->withErrors($validator)->withInput();
    }

    Session::put('exam_start_data', [
      'name'=> $request->name,
      'contact'=> $request->contact,
      'id_no'=> $request->id_no,
      'exam_code'=> $exam->exam_code,
    ]);
    return redirect()->route('front.exam-start');
  }
}
