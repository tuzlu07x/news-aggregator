<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\UserPreferenceController;

Route::post('register', [UserAuthController::class, 'register']);
Route::middleware('throttle:60,1')->post('login', [UserAuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'throttle:40,2'])->group(function () {
    Route::post('logout', [UserAuthController::class, 'logout']);
    Route::apiResource('preference', UserPreferenceController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::get('recommendations', [RecommendationController::class, 'index']);
    Route::apiResource('article', ArticleController::class);
});
