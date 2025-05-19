<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ExamController;
use App\Http\Controllers\Api\ExamQuestionController;
use App\Http\Controllers\Api\UserExamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('get-token', [AuthController::class, 'getToken']);


Route::middleware('verify.sanctum')->name('api.')->group(function () {
    Route::apiResource('exam', ExamController::class);

    //exam question
    Route::post('exam-question/{exam_id}', [ExamQuestionController::class, 'store']);
    Route::get('exam-question/{question_id}', [ExamQuestionController::class, 'show']);
    Route::put('exam-question/{question_id}', [ExamQuestionController::class, 'update']);
    Route::put('exam-question/{question_id}/update-status', [ExamQuestionController::class, 'updateStatus']);
    Route::delete('exam-question/{question_id}', [ExamQuestionController::class, 'destroy']);

    //user exam
    // Route::post('user-exam/{exam_id}', [UserExamController::class, 'show']);
});