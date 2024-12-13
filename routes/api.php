<?php

use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserPreferenceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [UserAuthController::class, 'register']);
Route::post('login', [UserAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [UserAuthController::class, 'logout']);
    Route::apiResource('preference', UserPreferenceController::class)->only(['index', 'store', 'update', 'destroy']);
});
