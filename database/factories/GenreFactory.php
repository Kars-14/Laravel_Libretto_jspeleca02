<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Genre>
 */
class GenreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genres = [
            'Fiction', 'Non-Fiction', 'Mystery', 'Romance', 'Science Fiction',
            'Fantasy', 'Thriller', 'Biography', 'History', 'Self-Help',
            'Poetry', 'Drama', 'Adventure', 'Horror', 'Comedy'
        ];
        
        return [
            'name' => $this->faker->randomElement($genres),
            'description' => $this->faker->sentence(10),
        ];
    }
}
