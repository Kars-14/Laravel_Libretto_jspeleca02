<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\ReviewController;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
    
    // Authors CRUD
    Route::apiResource('authors', AuthorController::class);
    
    // Books CRUD
    Route::apiResource('books', BookController::class);
    
    // Genres CRUD
    Route::apiResource('genres', GenreController::class);
    
    // Reviews CRUD
    Route::apiResource('reviews', ReviewController::class);
});
