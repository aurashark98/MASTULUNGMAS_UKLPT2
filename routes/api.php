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
use App\Http\Controllers\Api\V1\ProfilePhotoController;
use App\Http\Controllers\Api\V1\PortfolioController;
use App\Http\Controllers\Api\V1\PartnerApiController;
use App\Http\Controllers\Api\V1\PhoneOtpController;
use App\Http\Controllers\Api\V1\DisputeController;
use App\Http\Controllers\Api\V1\NotificationSettingApiController;

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

    // ── Public: Categories & Partners ─────────────────────────────────
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/partners',   [PartnerApiController::class, 'index']);

    // ── Protected Routes (Sanctum Token Required) ──────────────────────
    Route::middleware('auth:sanctum')->group(function () {

        // Auth
        Route::prefix('auth')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::get('/me',     [AuthController::class, 'me']);
        });

        // Profile Photo
        Route::post('/profile/photo',   [ProfilePhotoController::class, 'upload']);
        Route::delete('/profile/photo', [ProfilePhotoController::class, 'destroy']);

        // Phone OTP Verification
        Route::post('/phone/send-otp',   [PhoneOtpController::class, 'sendOtp']);
        Route::post('/phone/verify-otp', [PhoneOtpController::class, 'verifyOtp']);

        // Portfolio (mitra only)
        Route::get('/portfolio',               [PortfolioController::class, 'index']);
        Route::post('/portfolio',              [PortfolioController::class, 'store']);
        Route::put('/portfolio/{portfolio}',   [PortfolioController::class, 'update']);
        Route::delete('/portfolio/{portfolio}',[PortfolioController::class, 'destroy']);

        // Partners & Favorites
        Route::get('/partners/favorites',            [PartnerApiController::class, 'favorites']);
        Route::post('/partners/{partner}/favorite',  [PartnerApiController::class, 'toggleFavorite']);

        // Tasks (CRUD)
        Route::apiResource('tasks', TaskController::class)->names([
            'index' => 'api.tasks.index',
            'store' => 'api.tasks.store',
            'show' => 'api.tasks.show',
            'update' => 'api.tasks.update',
            'destroy' => 'api.tasks.destroy',
        ]);

        // Task Actions (mitra only)
        Route::post('/tasks/{task}/start',    [TaskActionController::class, 'start']);
        Route::post('/tasks/{task}/complete', [TaskActionController::class, 'complete']);

        // Bids
        Route::post('/tasks/{task}/bid',  [BidController::class, 'store']);
        Route::post('/bids/{bid}/accept', [BidController::class, 'accept']);

        // Disputes
        Route::get('/disputes',                   [DisputeController::class, 'index']);
        Route::post('/tasks/{task}/dispute',      [DisputeController::class, 'store']);
        Route::get('/disputes/{dispute}',         [DisputeController::class, 'show']);
        Route::post('/disputes/{dispute}/respond',[DisputeController::class, 'respond']);

        // Payment
        Route::post('/tasks/{task}/pay', [PaymentController::class, 'processPayment']);

        // Review
        Route::post('/tasks/{task}/review', [ReviewController::class, 'store']);

        // Chat
        Route::get('/chat',                      [ChatController::class, 'index']);
        Route::get('/chat/{chatRoom}/messages',  [ChatController::class, 'messages']);
        Route::post('/chat/{chatRoom}/messages', [ChatController::class, 'store']);

        // Notifications
        Route::get('/notifications',                [NotificationController::class, 'index']);
        Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead']);

        // Notification Settings
        Route::get('/notification-settings', [NotificationSettingApiController::class, 'show']);
        Route::put('/notification-settings', [NotificationSettingApiController::class, 'update']);
    });
});


