<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ScenarioController;
use App\Http\Controllers\Api\SubmissionController;
use App\Http\Controllers\AuthController;

Route::get('/scenarios', [ScenarioController::class, 'index']);
Route::get('/scenarios/{scenario}', [ScenarioController::class, 'show']);



Route::middleware('auth:sanctum')->group(function () {
    Route::post('/submissions', [SubmissionController::class, 'store']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});