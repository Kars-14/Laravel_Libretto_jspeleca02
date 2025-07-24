<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    /**
     * Show the dashboard
     */
    public function index()
    {
        $authorsCount = Author::count();
        $booksCount = Book::count();
        $genresCount = Genre::count();
        $reviewsCount = Review::count();

        $recentBooks = Book::with('author', 'genres')->latest()->take(10)->get();
        $recentAuthors = Author::latest()->take(10)->get();
        $recentGenres = Genre::latest()->take(10)->get();
        $recentReviews = Review::latest()->take(10)->get();

        return view('dashboard.index', compact(
            'authorsCount',
            'booksCount',
            'genresCount',
            'reviewsCount',
            'recentBooks',
            'recentAuthors',
            'recentGenres',
            'recentReviews'
        ));
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
        $books = Book::with(['author', 'genres', 'reviews'])->paginate(10);
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
        $reviews = Review::with(['book'])->paginate(10);
        return view('dashboard.reviews', compact('reviews'));
    }
    
    // ========== AUTHORS CRUD ========= =
    
    /**
     * Show the form for creating a new author
     */
    public function createAuthor()
    {
        return view('dashboard.authors.create');
    }
    
    /**
     * Store a newly created author
     */
    public function storeAuthor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'birth_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Author::create($request->all());

        return redirect()->route('authors.index')
            ->with('success', 'Author created successfully.');
    }
    
    /**
     * Display the specified author
     */
    public function showAuthor(Author $author)
    {
        $author->load('books');
        return view('dashboard.authors.show', compact('author'));
    }
    
    /**
     * Show the form for editing the specified author
     */
    public function editAuthor(Author $author)
    {
        return view('dashboard.authors.edit', compact('author'));
    }
    
    /**
     * Update the specified author
     */
    public function updateAuthor(Request $request, Author $author)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'birth_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $author->update($request->all());

        return redirect()->route('authors.index')
            ->with('success', 'Author updated successfully.');
    }
    
    /**
     * Remove the specified author
     */
    public function destroyAuthor(Author $author)
    {
        $author->delete();

        return redirect()->route('authors.index')
            ->with('success', 'Author deleted successfully.');
    }
    
    // ========== BOOKS CRUD =========
    
    /**
     * Show the form for creating a new book
     */
    public function createBook()
    {
        $authors = Author::all();
        $genres = Genre::all();
        return view('dashboard.books.create', compact('authors', 'genres'));
    }
    
    /**
     * Store a newly created book
     */
    public function storeBook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'publication_date' => 'nullable|date',
            'isbn' => 'nullable|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genres' => 'array',
            'genres.*' => 'exists:genres,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $book = Book::create($request->except('genres'));
        
        if ($request->has('genres')) {
            $book->genres()->sync($request->genres);
        }

        return redirect()->route('books.index')
            ->with('success', 'Book created successfully.');
    }
    
    /**
     * Display the specified book
     */
    public function showBook(Book $book)
    {
        $book->load(['author', 'genres', 'reviews']);
        return view('dashboard.books.show', compact('book'));
    }
    
    /**
     * Show the form for editing the specified book
     */
    public function editBook(Book $book)
    {
        $authors = Author::all();
        $genres = Genre::all();
        $book->load('genres');
        return view('dashboard.books.edit', compact('book', 'authors', 'genres'));
    }
    
    /**
     * Update the specified book
     */
    public function updateBook(Request $request, Book $book)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'publication_date' => 'nullable|date',
            'isbn' => 'nullable|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genres' => 'array',
            'genres.*' => 'exists:genres,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $book->update($request->except('genres'));
        
        if ($request->has('genres')) {
            $book->genres()->sync($request->genres);
        }

        return redirect()->route('books.index')
            ->with('success', 'Book updated successfully.');
    }
    
    /**
     * Remove the specified book
     */
    public function destroyBook(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully.');
    }
    
    // ========== GENRES CRUD =========
    
    /**
     * Show the form for creating a new genre
     */
    public function createGenre()
    {
        return view('dashboard.genres.create');
    }
    
    /**
     * Store a newly created genre
     */
    public function storeGenre(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:genres',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Genre::create($request->all());

        return redirect()->route('genres.index')
            ->with('success', 'Genre created successfully.');
    }
    
    /**
     * Display the specified genre
     */
    public function showGenre(Genre $genre)
    {
        $genre->load('books.author');
        return view('dashboard.genres.show', compact('genre'));
    }
    
    /**
     * Show the form for editing the specified genre
     */
    public function editGenre(Genre $genre)
    {
        return view('dashboard.genres.edit', compact('genre'));
    }
    
    /**
     * Update the specified genre
     */
    public function updateGenre(Request $request, Genre $genre)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:genres,name,' . $genre->id,
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $genre->update($request->all());

        return redirect()->route('genres.index')
            ->with('success', 'Genre updated successfully.');
    }
    
    /**
     * Remove the specified genre
     */
    public function destroyGenre(Genre $genre)
    {
        $genre->delete();

        return redirect()->route('genres.index')
            ->with('success', 'Genre deleted successfully.');
    }
    /**
     * Store a newly created review for a book (from book details page)
     */
    public function storeReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $review = new Review();
        $review->book_id = $request->book_id;
        $review->user_id = auth()->id();
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        return redirect()->route('books.show', $request->book_id)
            ->with('success', 'Review added successfully.');
    }
}
