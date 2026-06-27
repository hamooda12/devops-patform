<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ScenarioController;
use App\Http\Controllers\Api\SubmissionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\AdminDashboardController;
use App\Http\Controllers\Api\LeaderboardController;
use App\Http\Controllers\Api\UserProgressController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/me/progress', [UserProgressController::class, 'meProgress']);

    Route::get('/scenarios', [ScenarioController::class, 'index']);
    Route::get('/scenarios/{scenario}', [ScenarioController::class, 'show']);

    Route::post('/submissions', [SubmissionController::class, 'store']);
    Route::get('/submissions/{submission}', [SubmissionController::class, 'show']);
    Route::get('/my-submissions', [SubmissionController::class, 'mySubmissions']);

    Route::get('/leaderboard', [LeaderboardController::class, 'index']);
});

Route::middleware(['auth:sanctum', 'can:viewAdminDashboard'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index']);

        Route::post('/scenarios', [ScenarioController::class, 'store']);
        Route::put('/scenarios/{scenario}', [ScenarioController::class, 'update']);
        Route::delete('/scenarios/{scenario}', [ScenarioController::class, 'destroy']);
    });