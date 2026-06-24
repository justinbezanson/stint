<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Entry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Entry>
 */
class EntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_id' => Book::factory(),
            'user_id' => 1,
            'log_date' => fake()->dateTimeBetween('-30 days', 'now'),
            'duration' => fake()->numberBetween(10, 120),
        ];
    }
}
