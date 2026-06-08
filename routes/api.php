<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\BidController;
use App\Http\Controllers\Api\V1\ChatController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\ReviewController;
use App\Http\Controllers\Api\V1\NotificationController;
use App\Http\Controllers\Api\V1\TaskActionController;

/*
|--------------------------------------------------------------------------
| API Routes — MTM v1
|--------------------------------------------------------------------------
| Prefix  : /api/v1
| Auth    : Laravel Sanctum (Bearer Token)
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // ── Auth (Public) ──────────────────────────────────────────────────
    Route::prefix('auth')->group(function () {
        Route::post('/login',    [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
    });

    // ── Public: Categories ─────────────────────────────────────────────
    Route::get('/categories', [CategoryController::class, 'index']);

    // ── Protected Routes (Sanctum Token Required) ──────────────────────
    Route::middleware('auth:sanctum')->group(function () {

        // Auth
        Route::prefix('auth')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::get('/me',     [AuthController::class, 'me']);
        });

        // Tasks
        Route::apiResource('tasks', TaskController::class);

        // Task Actions (mitra only)
        Route::post('/tasks/{task}/start',    [TaskActionController::class, 'start']);
        Route::post('/tasks/{task}/complete', [TaskActionController::class, 'complete']);

        // Bids
        Route::post('/tasks/{task}/bid',  [BidController::class, 'store']);
        Route::post('/bids/{bid}/accept', [BidController::class, 'accept']);

        // Payment
        Route::post('/tasks/{task}/pay', [PaymentController::class, 'processPayment']);

        // Review
        Route::post('/tasks/{task}/review', [ReviewController::class, 'store']);

        // Chat
        Route::get('/chat',                          [ChatController::class, 'index']);
        Route::get('/chat/{chatRoom}/messages',      [ChatController::class, 'messages']);
        Route::post('/chat/{chatRoom}/messages',     [ChatController::class, 'store']);

        // Notifications
        Route::get('/notifications',               [NotificationController::class, 'index']);
        Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead']);
    });
});
