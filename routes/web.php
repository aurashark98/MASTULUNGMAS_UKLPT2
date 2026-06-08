<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\ServiceCategory;

use App\Http\Controllers\PageController;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/layanan', [PageController::class, 'layanan'])->name('layanan');
Route::get('/cara-kerja', [PageController::class, 'caraKerja'])->name('cara-kerja');
Route::get('/tentang-kami', [PageController::class, 'tentangKami'])->name('tentang-kami');

// User Dashboard (Default Breeze dashboard renamed/redirected)
Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/tasks/create', [App\Http\Controllers\TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [App\Http\Controllers\TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}', [App\Http\Controllers\TaskController::class, 'show'])->name('tasks.show');
    Route::post('/bids/{bid}/accept', [App\Http\Controllers\BidController::class, 'accept'])->name('bids.accept');
});

// Mitra Dashboard
Route::middleware(['auth', 'verified', 'role:mitra'])->prefix('mitra')->name('mitra.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Mitra\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/toggle-status', [App\Http\Controllers\Mitra\DashboardController::class, 'toggleStatus'])->name('toggle-status');
    Route::post('/tasks/{task}/bid', [App\Http\Controllers\BidController::class, 'store'])->name('tasks.bid');
    Route::post('/tasks/{task}/start', [App\Http\Controllers\Mitra\DashboardController::class, 'startTask'])->name('tasks.start');
    Route::post('/tasks/{task}/complete', [App\Http\Controllers\Mitra\DashboardController::class, 'completeTask'])->name('tasks.complete');
});

// Admin Dashboard
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/mitra/{user}/verify', [App\Http\Controllers\Admin\DashboardController::class, 'verifyMitra'])->name('mitra.verify');
    Route::post('/mitra/{user}/reject', [App\Http\Controllers\Admin\DashboardController::class, 'rejectMitra'])->name('mitra.reject');
    
    // Resource Management (CRUD Penuh untuk Semua Tabel Aplikasi)
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::resource('mitra-profiles', App\Http\Controllers\Admin\MitraProfileController::class);
    Route::resource('categories', App\Http\Controllers\Admin\ServiceCategoryController::class);
    Route::resource('tasks', App\Http\Controllers\Admin\TaskController::class);
    Route::resource('task-bids', App\Http\Controllers\Admin\TaskBidController::class);
    Route::resource('task-assignments', App\Http\Controllers\Admin\TaskAssignmentController::class);
    Route::resource('payments', App\Http\Controllers\Admin\PaymentController::class);
    Route::resource('reviews', App\Http\Controllers\Admin\ReviewController::class);
    Route::resource('chat-rooms', App\Http\Controllers\Admin\ChatRoomController::class);
    Route::resource('messages', App\Http\Controllers\Admin\MessageController::class);
    Route::resource('activity-logs', App\Http\Controllers\Admin\ActivityLogController::class)->only(['index', 'destroy']);
});

use App\Http\Controllers\Auth\GoogleController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/register-mitra', [ProfileController::class, 'showRegisterMitra'])->name('profile.register-mitra');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password/send-otp', [ProfileController::class, 'sendPasswordOTP'])->name('profile.password.send-otp');
    Route::post('/profile/upgrade', [ProfileController::class, 'upgradeToMitra'])->name('profile.upgrade');
    Route::post('/profile/switch-role', [ProfileController::class, 'switchRole'])->name('profile.switch-role');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Google Authentication Routes
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');
Route::get('/auth/google/mock-select', [GoogleController::class, 'showMockSelect'])->name('auth.google.mock-select');
Route::post('/auth/google/mock-select', [GoogleController::class, 'processMockSelect'])->name('auth.google.mock-select.post');

require __DIR__.'/auth.php';
