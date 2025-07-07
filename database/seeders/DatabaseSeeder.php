<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Review;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create authors with books, genres, and reviews
        Author::factory(10)->create()->each(function ($author) {
            $books = Book::factory(3)->create(['author_id' => $author->id]);
            
            $books->each(function ($book) {
                $genres = Genre::factory(2)->create();
                $book->genres()->attach($genres);
                
                Review::factory(5)->create(['book_id' => $book->id]);
            });
        });
    }
}
