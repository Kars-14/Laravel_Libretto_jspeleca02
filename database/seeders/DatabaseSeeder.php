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
        // Create a test user for authentication
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create sample data
        Author::factory(10)->create();
        Genre::factory(10)->create();
        
        // Create books and associate with authors and genres
        $authors = Author::all();
        $genres = Genre::all();
        
        for ($i = 0; $i < 10; $i++) {
            $book = Book::factory()->create([
                'author_id' => $authors->random()->id,
            ]);
            
            // Attach 1-3 random genres to each book
            $book->genres()->attach($genres->random(rand(1, 3)));
            
            // Create 2-5 reviews for each book
            Review::factory(rand(2, 5))->create(['book_id' => $book->id]);
        }
    }
}
