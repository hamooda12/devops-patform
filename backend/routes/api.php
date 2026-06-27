<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ScenarioController;
use App\Http\Controllers\Api\SubmissionController;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/scenarios', [ScenarioController::class, 'index']);
    Route::get('/scenarios/{scenario}', [ScenarioController::class, 'show']);

    Route::post('/submissions', [SubmissionController::class, 'store']);
    Route::get('/submissions/{submission}', [SubmissionController::class, 'show']);
    Route::get('/my-submissions', [SubmissionController::class, 'mySubmissions']);

    Route::post('/scenarios', [ScenarioController::class, 'store']);
Route::put('/scenarios/{scenario}', [ScenarioController::class, 'update']);
Route::delete('/scenarios/{scenario}', [ScenarioController::class, 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);
});