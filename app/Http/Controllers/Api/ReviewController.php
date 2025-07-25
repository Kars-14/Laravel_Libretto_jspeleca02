<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews.
     */
    public function index()
    {
        $reviews = Review::with(['book.author'])->paginate(15);
        
        return response()->json([
            'status' => 'success',
            'data' => $reviews
        ]);
    }

    /**
     * Store a newly created review.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if user already reviewed this book
        $existingReview = Review::where('book_id', $request->book_id)
            ->where('user_id', $request->user()->id)
            ->first();

        if ($existingReview) {
            return response()->json([
                'status' => 'error',
                'message' => 'You have already reviewed this book'
            ], 422);
        }

        $review = Review::create([
            'book_id' => $request->book_id,
            'user_id' => $request->user()->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        $review->load(['book.author', 'user']);

        return response()->json([
            'status' => 'success',
            'message' => 'Review created successfully',
            'data' => $review
        ], 201);
    }

    /**
     * Display the specified review or all reviews for a book if book_id is provided.
     */
    public function show($id)
    {
        // If $id is a book id, return all reviews for that book
        $bookReviews = \App\Models\Review::where('book_id', $id)->with('user')->get();
        if ($bookReviews->count() > 0) {
            return response()->json([
                'status' => 'success',
                'data' => $bookReviews,
                'reviews_count' => $bookReviews->count()
            ]);
        }
        // Otherwise, fallback to single review by id
        $review = \App\Models\Review::with(['book.author', 'user'])->find($id);
        if ($review) {
            return response()->json([
                'status' => 'success',
                'data' => $review
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Review or book not found'
        ], 404);
    }

    /**
     * Update the specified review.
     */
    public function update(Request $request, Review $review)
    {
        // Check if the review belongs to the authenticated user
        if ($review->user_id !== $request->user()->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized to update this review'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $review->update($request->validated());
        $review->load(['book.author', 'user']);

        return response()->json([
            'status' => 'success',
            'message' => 'Review updated successfully',
            'data' => $review
        ]);
    }

    /**
     * Remove the specified review.
     */
    public function destroy(Request $request, Review $review)
    {
        // Check if the review belongs to the authenticated user
        if ($review->user_id !== $request->user()->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized to delete this review'
            ], 403);
        }

        $review->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Review deleted successfully'
        ]);
    }
}
