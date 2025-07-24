<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\DestroyRequest;
use App\Http\Requests\Book\IndexRequest;
use App\Http\Requests\Book\StoreRequest;
use App\Http\Requests\Book\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Services\Book\Destroy;
use App\Http\Services\Book\Index;
use App\Http\Services\Book\Store;
use App\Http\Services\Book\Update;
use App\Models\Book;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::query();

        if ($request->has('search') && $request->input('search') != '') {
            $books->where('title', 'like', '%' . $request->input('search') . '%');
        }

        return response()->json($books->get());
    }

    public function store(StoreRequest $request, Store $store)
    {
        $book = $store($request->validated());

        return response()->json([
            'message' => 'Successfully stored the book.',
            'data' => $book
        ]);
    }

    public function update(UpdateRequest $request, Update $update, Book $bookToUpdate)
    {
        Log::info("Updating book ID: {$bookToUpdate->id}", [
            'validated_data' => $request->validated()
        ]);
        $updatedBook = $update($request->validated(), $bookToUpdate);

        return response()->json([
            'message' => 'Successfully updated the book.',
            'data' => $updatedBook
        ]);
    }

    public function destroy(DestroyRequest $request, Destroy $destroy, Book $book)
    {
        $destroy($book);

        return response()->json([
            'message' => 'Successfully deleted the book.',
        ]);
    }

    public function attachGenres(Request $request, $bookId)
    {
        $validated = $request->validate([
            'genre_ids' => 'required|array',
            'genre_ids.*' => 'exists:genres,id',
        ]);

        $book = Book::findOrFail($bookId);
        $book->genres()->sync($validated['genre_ids']);

        return response()->json([
            'message' => 'Genres linked successfully',
            'book' => $book->load('genres')
        ]);
    }
}
