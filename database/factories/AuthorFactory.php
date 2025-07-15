<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $authors = [
            'J.K. Rowling', 'Stephen King', 'Agatha Christie', 'Ernest Hemingway',
            'Jane Austen', 'Mark Twain', 'George Orwell', 'F. Scott Fitzgerald',
            'Harper Lee', 'Charles Dickens', 'Gabriel García Márquez', 'Toni Morrison',
            'Leo Tolstoy', 'Maya Angelou', 'Edgar Allan Poe'
        ];
        
        return [
            'name' => $this->faker->randomElement($authors),
        ];
    }
}
