<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ExamCategoryController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamQuestionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'login' => true,
    'register' => true,
    'reset' => true,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::group(['middleware' => ['auth'], 'prefix' => 'dashboard'], function () {
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('users', UserController::class);
    Route::resource('exam-categories', ExamCategoryController::class);
    // Exam questions routes with exam id prefix
    Route::prefix('exams/{exam}')->group(function () {
        Route::get('questions', [ExamQuestionController::class, 'index'])->name('exam_questions.index');
        Route::post('questions', [ExamQuestionController::class, 'store'])->name('exam_questions.store');

        Route::get('questions/{question}/edit', [ExamQuestionController::class, 'edit'])->name('exam_questions.edit');
        Route::put('questions/{question}', [ExamQuestionController::class, 'update'])->name('exam_questions.update');
        Route::delete('questions/{question}', [ExamQuestionController::class, 'destroy'])->name('exam_questions.destroy');
    });

    Route::get('exam/create-link/{exam}', [ExamController::class, 'createLink'])->name('exam.create-link');
    Route::resource('exams', ExamController::class);
});


