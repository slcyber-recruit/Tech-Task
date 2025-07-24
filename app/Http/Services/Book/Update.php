<?php

namespace App\Http\Services\Book;

use App\Models\Book;

class Update
{
    public function __invoke(array $data, Book $book): Book
    {
        $book->fill($data);

        if ($book->isDirty()) {
            $book->save();
        }

        return $book;
    }
}
