<?php

use App\Http\Controllers\Front\ExamQuestionController;
use App\Http\Controllers\Front\ExamStartController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\JoinExamController;
use App\Http\Controllers\Front\ExamController;
use App\Http\Controllers\Front\ExamResultController;
use App\Models\Exam;
use Illuminate\Support\Facades\Route;


Route::get('/', [FrontController::class, 'home'])->name('front.home');


Route::get('join-exam', [JoinExamController::class, 'joinExam'])->name('front.join-exam');
Route::post('join-exam', [JoinExamController::class, 'joinExamSubmit'])->name('front.join-exam-submit');
Route::get('exam/{exam_code}', [JoinExamController::class, 'examForm'])->name('front.exam');
Route::post('exam/{exam_code}', [JoinExamController::class, 'examSubmit'])->name('front.exam-form-submit');
Route::get('exam-start', [ExamStartController::class, 'examStart'])->name('front.exam-start');
Route::post('exam-start', [ExamStartController::class, 'examSubmit'])->name('front.exam-submit');

Route::view('page/terms', 'front.page.terms')->name('front.page.terms');
Route::view('page/privacy', 'front.page.privacy')->name('front.page.privacy');
Route::view('page/about', 'front.page.about')->name('front.page.about');
Route::view('page/cookie-policy', 'front.page.cookie-policy')->name('front.page.cookie-policy');




Route::middleware('auth')->prefix('exams/{exam}')->group(function () {
    Route::get('questions', [ExamQuestionController::class, 'index'])->name('front.exam_questions.index');
    Route::post('questions', [ExamQuestionController::class, 'store'])->name('front.exam_questions.store');

    Route::get('questions/{question}/edit', [ExamQuestionController::class, 'edit'])->name('front.exam_questions.edit');
    Route::put('questions/{question}', [ExamQuestionController::class, 'update'])->name('front.exam_questions.update');
    Route::delete('questions/{question}', [ExamQuestionController::class, 'destroy'])->name('front.exam_questions.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('exams', ExamController::class);
    Route::put('exam/{question_id}/update-status', [ExamController::class, 'updateStatus']);

    Route::get('exam-results/{exam_id}', [ExamResultController::class, 'index'])->name('front.exam.results');
    Route::get('/results/{answer}', [ExamResultController::class, 'show'])->name('front.exam.results.show');
    Route::get('/exam-winner', [ExamResultController::class, 'winner'])->name('front.exam.winner');

});







Route::view('demo-exam-list', 'front.demo.exam-list');
Route::view('demo-exam-create', 'front.demo.exam-create');
Route::view('demo-exam-show', 'front.demo.exam-show');
Route::view('demo-exam-result', 'front.demo.exam-result');
Route::view('demo-exam-winner', 'front.demo.exam-winner');
Route::view('demo-exam-result-detail', 'front.demo.exam-result-detail');

