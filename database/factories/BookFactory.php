<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $books = [
            'The Great Gatsby', 'To Kill a Mockingbird', '1984', 'Pride and Prejudice',
            'The Catcher in the Rye', 'Lord of the Flies', 'Jane Eyre', 'Wuthering Heights',
            'The Chronicles of Narnia', 'Harry Potter and the Sorcerer\'s Stone',
            'The Hobbit', 'Brave New World', 'Animal Farm', 'Fahrenheit 451',
            'One Hundred Years of Solitude'
        ];
        
        return [
            'title' => $this->faker->randomElement($books),
            'publication_year' => $this->faker->numberBetween(1950, 2024),
            'isbn' => $this->faker->isbn13(),
            'author_id' => Author::factory(),
        ];
    }
}
