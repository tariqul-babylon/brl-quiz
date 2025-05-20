<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ExamController;
use App\Http\Controllers\Api\ExamQuestionController;
use App\Http\Controllers\Api\ExamResultController;
use App\Http\Controllers\Api\UserExamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('get-token', [AuthController::class, 'getToken']);


Route::middleware('verify.sanctum')->name('api.')->group(function () {
    Route::apiResource('exam', ExamController::class);
    Route::put('exam/{question_id}/update-status', [ExamController::class, 'updateStatus']);

    // exam question
    Route::post('exam-question/{exam_id}', [ExamQuestionController::class, 'store']);
    Route::get('exam-question/{question_id}', [ExamQuestionController::class, 'show']);
    Route::put('exam-question/{question_id}', [ExamQuestionController::class, 'update']);
    
    Route::delete('exam-question/{question_id}', [ExamQuestionController::class, 'destroy']);

    // user exam
    Route::get('user-exam/show/{exam_code}', [UserExamController::class, 'show']);
    Route::post('user-exam/start-exam', [UserExamController::class, 'startExam']);
    Route::post('user-exam/submit-exam', [UserExamController::class, 'submitExam']);

    // exam result
    Route::get('exam-result/{exam}/answer', [ExamResultController::class, 'showResult']);
    Route::get('exam-result/{exam}/answer-detail', [ExamResultController::class, 'showResultDetail']);
});