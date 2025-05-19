<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/get-token', [AuthController::class, 'getToken']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/demo', [AuthController::class, 'demo']);
});