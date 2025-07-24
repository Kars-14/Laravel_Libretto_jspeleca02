<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of books.
     */
    public function index()
    {
        $books = Book::with(['author', 'genres', 'reviews'])->paginate(15);
        
        return response()->json([
            'status' => 'success',
            'data' => $books
        ]);
    }

    /**
     * Store a newly created book.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'isbn' => 'nullable|string|unique:books,isbn',
            'publication_date' => 'nullable|date',
            'description' => 'nullable|string',
            'pages' => 'nullable|integer|min:1',
            'genre_ids' => 'nullable|array',
            'genre_ids.*' => 'exists:genres,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $book = Book::create($request->only([
            'title', 'author_id', 'isbn', 'publication_date', 'description', 'pages'
        ]));

        // Attach genres if provided
        if ($request->has('genre_ids')) {
            $book->genres()->attach($request->genre_ids);
        }

        $book->load(['author', 'genres']);

        return response()->json([
            'status' => 'success',
            'message' => 'Book created successfully',
            'data' => $book
        ], 201);
    }

    /**
     * Display the specified book.
     */
    public function show(Book $book)
    {
        $book->load(['author', 'genres', 'reviews.user']);
        
        return response()->json([
            'status' => 'success',
            'data' => $book
        ]);
    }

    /**
     * Update the specified book.
     */
    public function update(Request $request, Book $book)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'isbn' => 'nullable|string|unique:books,isbn,' . $book->id,
            'publication_date' => 'nullable|date',
            'description' => 'nullable|string',
            'pages' => 'nullable|integer|min:1',
            'genre_ids' => 'nullable|array',
            'genre_ids.*' => 'exists:genres,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $book->update($request->only([
            'title', 'author_id', 'isbn', 'publication_date', 'description', 'pages'
        ]));

        // Sync genres if provided
        if ($request->has('genre_ids')) {
            $book->genres()->sync($request->genre_ids);
        }

        $book->load(['author', 'genres']);

        return response()->json([
            'status' => 'success',
            'message' => 'Book updated successfully',
            'data' => $book
        ]);
    }

    /**
     * Remove the specified book.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Book deleted successfully'
        ]);
    }

    /**
     * Get all reviews for a specific book.
     */
    public function reviews(Book $book)
    {
        $reviews = $book->reviews()->with('user')->latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'book' => $book->load(['author', 'genres']),
                'reviews' => $reviews,
                'reviews_count' => $reviews->count()
            ]
        ]);
    }
}
