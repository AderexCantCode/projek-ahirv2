<?php

use App\Http\Controllers\Admin\GameController as AdminGameController;
use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/games/{id}', [GameController::class, 'show'])->name('games.show');

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User routes
Route::middleware(['auth'])->group(function () {
    Route::get('/transaction/create/{id}', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transaction', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transaction/history', [TransactionController::class, 'history'])->name('transactions.history');
    Route::get('/transaction/checkout', [TransactionController::class, 'checkout'])->name('transactions.checkout');
    Route::get('/transaction/success', [TransactionController::class, 'success'])->name('transactions.success');
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::resource('games', AdminGameController::class);
    
    Route::prefix('games/{gameId}')->name('games.')->group(function () {
        Route::resource('packages', AdminPackageController::class)->except(['show']);
        Route::get('packages', [AdminPackageController::class, 'index'])->name('packages.index');
    });
});