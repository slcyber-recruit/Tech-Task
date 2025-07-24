<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        Book::truncate();

        Book::factory()
            ->count(5)
            ->create()
            ->each(function ($book) {
                $book->update(['rating' => rand(1, 10)]);
            });
    }
}
