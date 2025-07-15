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
        // Create 10 authors
        $authors = Author::factory(10)->create();
        
        // Create 10 genres
        $genres = Genre::factory(10)->create();
        
        // Create 10 books and assign them to random authors
        $books = collect();
        for ($i = 0; $i < 10; $i++) {
            $book = Book::factory()->create([
                'author_id' => $authors->random()->id,
            ]);
            
            // Attach 1-3 random genres to each book
            $randomGenres = $genres->random(rand(1, 3));
            $book->genres()->attach($randomGenres);
            
            $books->push($book);
        }
        
        // Create 2-5 reviews for each book
        $books->each(function ($book) {
            Review::factory(rand(2, 5))->create(['book_id' => $book->id]);
        });
    }
}
