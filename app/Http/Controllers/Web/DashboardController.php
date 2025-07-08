<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Review;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the dashboard
     */
    public function index()
    {
        $stats = [
            'authors' => Author::count(),
            'books' => Book::count(),
            'genres' => Genre::count(),
            'reviews' => Review::count(),
        ];

        return view('dashboard.index', compact('stats'));
    }

    /**
     * Show authors page
     */
    public function authors()
    {
        $authors = Author::with('books')->paginate(10);
        return view('dashboard.authors', compact('authors'));
    }

    /**
     * Show books page
     */
    public function books()
    {
        $books = Book::with(['authors', 'genres', 'reviews'])->paginate(10);
        return view('dashboard.books', compact('books'));
    }

    /**
     * Show genres page
     */
    public function genres()
    {
        $genres = Genre::with('books')->paginate(10);
        return view('dashboard.genres', compact('genres'));
    }

    /**
     * Show reviews page
     */
    public function reviews()
    {
        $reviews = Review::with(['book', 'user'])->paginate(10);
        return view('dashboard.reviews', compact('reviews'));
    }
}
