<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ScenarioController;
use App\Http\Controllers\Api\SubmissionController;
Route::get('/scenarios', [ScenarioController::class, 'index']);
Route::get('/scenarios/{scenario}', [ScenarioController::class, 'show']);


Route::post('/submissions', [SubmissionController::class, 'store']);