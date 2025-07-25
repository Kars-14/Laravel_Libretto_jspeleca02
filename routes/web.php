<?php

use Illuminate\Support\Facades\Route; // This line is already correct
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes (only for guests)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected web routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Authors CRUD
    Route::get('/authors', [DashboardController::class, 'authors'])->name('authors.index');
    Route::get('/authors/create', [DashboardController::class, 'createAuthor'])->name('authors.create');
    Route::post('/authors', [DashboardController::class, 'storeAuthor'])->name('authors.store');
    Route::get('/authors/{author}', [DashboardController::class, 'showAuthor'])->name('authors.show');
    Route::get('/authors/{author}/edit', [DashboardController::class, 'editAuthor'])->name('authors.edit');
    Route::put('/authors/{author}', [DashboardController::class, 'updateAuthor'])->name('authors.update');
    Route::delete('/authors/{author}', [DashboardController::class, 'destroyAuthor'])->name('authors.destroy');
    
    // Books CRUD
    Route::get('/books', [DashboardController::class, 'books'])->name('books.index');
    Route::get('/books/create', [DashboardController::class, 'createBook'])->name('books.create');
    Route::post('/books', [DashboardController::class, 'storeBook'])->name('books.store');
    Route::get('/books/{book}', [DashboardController::class, 'showBook'])->name('books.show');
    Route::get('/books/{book}/edit', [DashboardController::class, 'editBook'])->name('books.edit');
    Route::put('/books/{book}', [DashboardController::class, 'updateBook'])->name('books.update');
    Route::delete('/books/{book}', [DashboardController::class, 'destroyBook'])->name('books.destroy');
    
    // Genres CRUD
    Route::get('/genres', [DashboardController::class, 'genres'])->name('genres.index');
    Route::get('/genres/create', [DashboardController::class, 'createGenre'])->name('genres.create');
    Route::post('/genres', [DashboardController::class, 'storeGenre'])->name('genres.store');
    Route::get('/genres/{genre}', [DashboardController::class, 'showGenre'])->name('genres.show');
    Route::get('/genres/{genre}/edit', [DashboardController::class, 'editGenre'])->name('genres.edit');
    Route::put('/genres/{genre}', [DashboardController::class, 'updateGenre'])->name('genres.update');
    Route::delete('/genres/{genre}', [DashboardController::class, 'destroyGenre'])->name('genres.destroy');
    
    // Reviews CRUD
    Route::get('/reviews', [DashboardController::class, 'reviews'])->name('reviews.index');
    Route::get('/reviews/create', [DashboardController::class, 'createReview'])->name('reviews.create');
    Route::post('/reviews', [DashboardController::class, 'storeReview'])->name('reviews.store');
    Route::get('/reviews/{review}', [DashboardController::class, 'showReview'])->name('reviews.show');
    Route::get('/reviews/{review}/edit', [DashboardController::class, 'editReview'])->name('reviews.edit');
    Route::put('/reviews/{review}', [DashboardController::class, 'updateReview'])->name('reviews.update');
    Route::delete('/reviews/{review}', [DashboardController::class, 'destroyReview'])->name('reviews.destroy');
});
