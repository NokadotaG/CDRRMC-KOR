<?php

use App\Http\Controllers\Api\ResponderAuthController;
use App\Http\Controllers\Api\ResponderController;
use App\Http\Controllers\Api\CivilAuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EvacuationController;
use Illuminate\Support\Facades\Route;

Route::prefix('responder')->name('responder.')->group(function () {
    // Public routes
    Route::post('/login', [ResponderAuthController::class, 'login']);

    // Protected routes (require auth:responder middleware)
    Route::middleware('auth:responder')->group(function () {
        Route::get('/me', [ResponderAuthController::class, 'me']);
        Route::post('/logout', [ResponderAuthController::class, 'logout']);
        Route::put('/profile', [ResponderController::class, 'updateProfile']);
        Route::post('/password', [ResponderController::class, 'updatePassword']);
        Route::post('/profile/image', [ResponderController::class, 'uploadProfileImage']);
        Route::get('/dashboard', [ResponderController::class, 'dashboard']);
        
        // Tasks
        Route::get('/tasks/{responderId}', [TaskController::class, 'responderTasks']);
        Route::put('/tasks/{taskId}/status', [TaskController::class, 'updateStatus']);
        Route::post('/tasks/{taskId}/feedback', [TaskController::class, 'submitFeedback']);
        
        // Evacuation
        Route::get('/evacuation/points', [EvacuationController::class, 'getPoints']);
        
    });
});

Route::prefix('civil')->name('civil.')->group(function () {
    // Public routes
    Route::post('/register', [CivilAuthController::class, 'register']); // References updated class
    Route::post('/login', [CivilAuthController::class, 'login']);
    Route::post('/forgot-password', [CivilAuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [CivilAuthController::class, 'resetPassword']);
    // Protected routes (require auth:sanctum middleware)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', function (Request $request) {
            return $request->user(); // Or customize to return user data
        });
        Route::post('/logout', [CivilAuthController::class, 'logout']);
        // Add more protected routes here if needed, e.g., profile updates
    });
});

