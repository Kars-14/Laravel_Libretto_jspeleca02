<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected web routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/authors', [DashboardController::class, 'authors'])->name('authors.index');
    Route::get('/books', [DashboardController::class, 'books'])->name('books.index');
    Route::get('/genres', [DashboardController::class, 'genres'])->name('genres.index');
    Route::get('/reviews', [DashboardController::class, 'reviews'])->name('reviews.index');
});
