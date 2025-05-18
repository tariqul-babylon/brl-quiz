<?php

use App\Http\Controllers\Front\JoinExamController;
use Illuminate\Support\Facades\Route;


Route::get('join-exam', [JoinExamController::class, 'joinExam'])->name('front.join-exam');
Route::post('join-exam', [JoinExamController::class, 'joinExamSubmit'])->name('front.join-exam-submit');

Route::get('exam-form/{exam_code}', [JoinExamController::class, 'examForm'])->name('front.exam-form');