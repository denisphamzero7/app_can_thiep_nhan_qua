<?php

use App\Modules\TvIntervention\Controllers\TvInterventionController;
use Illuminate\Support\Facades\Route;

// Public endpoints cho cả TV App và Web
Route::get('/status', [TvInterventionController::class, 'getStatus']);
Route::post('/settings', [TvInterventionController::class, 'updateSettings']);
Route::post('/toggle', [TvInterventionController::class, 'updateSettings']);
Route::get('/questions', [TvInterventionController::class, 'getQuestions']);
Route::post('/questions', [TvInterventionController::class, 'storeQuestion']);
Route::delete('/questions/{id}', [TvInterventionController::class, 'deleteQuestion']);
Route::post('/report', [TvInterventionController::class, 'report']);
