<?php

namespace App\Http\Services\Book;

use App\Models\Book;
use Illuminate\Support\Arr;

class Store
{
    public function __invoke(array $data): Book
    {
        $book = Book::create([
            'title' => $data['title'],
            'author' => $data['author'],
            'rating' => $data['rating']
        ]);

        // Attach genres to the book
        $book->genres()->sync(Arr::get($data, 'genres', []));

        return $book;
    }
}
