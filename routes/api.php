<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ExamController;
use App\Http\Controllers\Api\ExamQuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('get-token', [AuthController::class, 'getToken']);


Route::middleware('verify.sanctum')->name('api.')->group(function () {
    Route::apiResource('exam', ExamController::class);

    //exam question
    Route::post('exam-question/{exam_id}', [ExamQuestionController::class, 'store']);
    Route::put('exam-question/{exam_id}/{question_id}', [ExamQuestionController::class, 'update']);
    Route::delete('exam-question/{exam_id}/{question_id}', [ExamQuestionController::class, 'destroy']);
});