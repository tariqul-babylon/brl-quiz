<?php

use App\Http\Controllers\Front\ExamStartController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\JoinExamController;
use Illuminate\Support\Facades\Route;


Route::get('/', [FrontController::class, 'home'])->name('front.home');


Route::get('join-exam', [JoinExamController::class, 'joinExam'])->name('front.join-exam');
Route::post('join-exam', [JoinExamController::class, 'joinExamSubmit'])->name('front.join-exam-submit');

Route::get('exam/{exam_code}', [JoinExamController::class, 'exam'])->name('front.exam');
Route::post('exam/{exam_code}', [JoinExamController::class, 'examSubmit'])->name('front.exam-submit');
Route::get('exam/{exam_code}/alert', [JoinExamController::class, 'examAlert'])->name('front.exam-alert');

Route::get('exam-form/{exam_code}', [JoinExamController::class, 'examForm'])->name('front.exam-form');

Route::get('exam-start', [ExamStartController::class, 'examStart'])->name('front.exam-start');
Route::post('exam-start', [ExamStartController::class, 'examSubmit'])->name('front.exam-submit');

