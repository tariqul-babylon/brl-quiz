<?php

use App\Http\Controllers\Front\ExamQuestionController;
use App\Http\Controllers\Front\ExamStartController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\JoinExamController;
use App\Http\Controllers\Front\ExamController;
use App\Http\Controllers\Front\ExamResultController;
use Illuminate\Support\Facades\Route;


Route::get('/', [FrontController::class, 'home'])->name('front.home');


Route::get('join-exam', [JoinExamController::class, 'joinExam'])->name('front.join-exam');
Route::post('join-exam', [JoinExamController::class, 'joinExamSubmit'])->name('front.join-exam-submit');

Route::get('exam/{exam_code}', [JoinExamController::class, 'examForm'])->name('front.exam');
Route::post('exam/{exam_code}', [JoinExamController::class, 'examSubmit'])->name('front.exam-form-submit');

Route::prefix('exams/{exam}')->group(function () {
    Route::get('questions', [ExamQuestionController::class, 'index'])->name('front.exam_questions.index');
    Route::post('questions', [ExamQuestionController::class, 'store'])->name('front.exam_questions.store');

    Route::get('questions/{question}/edit', [ExamQuestionController::class, 'edit'])->name('front.exam_questions.edit');
    Route::put('questions/{question}', [ExamQuestionController::class, 'update'])->name('front.exam_questions.update');
    Route::delete('questions/{question}', [ExamQuestionController::class, 'destroy'])->name('front.exam_questions.destroy');
});

Route::resource('exams', ExamController::class);

Route::get('exam-start', [ExamStartController::class, 'examStart'])->name('front.exam-start');
Route::post('exam-start', [ExamStartController::class, 'examSubmit'])->name('front.exam-submit');

Route::get('exam-results', [ExamResultController::class, 'index'])->name('exam.results');


