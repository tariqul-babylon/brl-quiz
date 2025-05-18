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

Route::middleware(['auth'])->group(function () {
    Route::get('/change-password', [App\Http\Controllers\ChangePasswordController::class, 'showChangeForm'])->name('password.change');
    Route::post('/change-password', [App\Http\Controllers\ChangePasswordController::class, 'update'])->name('password.update');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::group(['middleware' => ['auth']], function () {
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('users', UserController::class);
    Route::resource('exam-categories', ExamCategoryController::class);
    // Exam questions routes with exam id prefix
    Route::prefix('exams/{exam}')->group(function () {
        Route::get('questions', [ExamQuestionController::class, 'index'])->name('exam_questions.index');
        Route::post('questions', [ExamQuestionController::class, 'store'])->name('exam_questions.store');
        // You can add more routes like edit, update, delete questions as needed
    });
    Route::resource('exams', ExamController::class);
});
