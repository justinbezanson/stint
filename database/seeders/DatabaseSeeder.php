<?php

namespace Database\Seeders;

use App\Models\Author;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\Entry;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Author::factory(10)->create()->each(function ($author) {
            $author->books()->saveMany(Book::factory(rand(1, 5))->make());
        });

        Entry::factory(50)->create();
    }
}
