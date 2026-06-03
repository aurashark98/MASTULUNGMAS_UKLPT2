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
    Route::post('/tasks/{task}/bid', [App\Http\Controllers\BidController::class, 'store'])->name('tasks.bid');
});

// Admin Dashboard
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/mitra/{user}/verify', [App\Http\Controllers\Admin\DashboardController::class, 'verifyMitra'])->name('mitra.verify');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
