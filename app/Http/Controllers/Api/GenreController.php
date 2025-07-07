<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    /**
     * Display a listing of genres.
     */
    public function index()
    {
        $genres = Genre::with('books')->paginate(15);
        
        return response()->json([
            'status' => 'success',
            'data' => $genres
        ]);
    }

    /**
     * Store a newly created genre.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:genres,name',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $genre = Genre::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Genre created successfully',
            'data' => $genre
        ], 201);
    }

    /**
     * Display the specified genre.
     */
    public function show(Genre $genre)
    {
        $genre->load('books.author');
        
        return response()->json([
            'status' => 'success',
            'data' => $genre
        ]);
    }

    /**
     * Update the specified genre.
     */
    public function update(Request $request, Genre $genre)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:genres,name,' . $genre->id,
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $genre->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Genre updated successfully',
            'data' => $genre
        ]);
    }

    /**
     * Remove the specified genre.
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Genre deleted successfully'
        ]);
    }
}
