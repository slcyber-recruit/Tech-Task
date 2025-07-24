<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; // Required for Request injection
use App\Models\Book; // Required for Book model
use App\Http\Services\Book\Update as BookUpdateService; // Required for the service

/*
|--------------------------------------------------------------------------
| Web Routes (with Controller Logic Embedded)
|--------------------------------------------------------------------------
|
| WARNING: Embedding controller logic directly into web.php is generally
|          considered BAD PRACTICE for larger applications. It makes
|          your routes file difficult to read, maintain, and test.
|          Laravel's MVC pattern (Controllers, Models, Views) is designed
|          to separate concerns and improve code organization.
|
|          This file demonstrates the literal request to "export all code
|          in WebBookController to web.php" by moving the method logic
|          into route closures. For a real application, you should keep
|          your logic in dedicated Controller classes.
|
*/

// Route for displaying a listing of books (index)
Route::get('/', function (Request $request) {
    $books = Book::query();

    if ($request->has('search') && $request->input('search') != '') {
        $searchTerm = $request->input('search');
        $books->where('title', 'like', '%' . $searchTerm . '%');
    }

    $books = $books->get();

    return view('welcome', ['books' => $books]);
})->name('books.index');

// Route for showing the form for editing a specific book (edit)
// Uses Route Model Binding (Book $book)
Route::get('/books/{book}/edit', function (Book $book) {
    return view('edit', compact('book'));
})->name('books.edit');

// Route for updating a specific book (update)
// Uses Route Model Binding (Book $book) and injects the service
Route::put('/books/{book}', function (Request $request, Book $book, BookUpdateService $bookUpdateService) {
    // 1. Validate the incoming request data
    $validatedData = $request->validate([
        'title' => 'string|max:255',
        'author' => 'string|max:255',
        'rating' => 'integer|min:1|max:10',
    ]);

    // 2. Use your service to update the book
    $updatedBook = $bookUpdateService($validatedData, $book);

    // 3. Redirect back with a success message or to the book list
    return redirect()->route('books.index')->with('success', 'Book updated successfully!');
})->name('books.update');

// Route for soft-deleting a specific book (destroy)
// Uses Route Model Binding (Book $book)
Route::delete('/books/{book}', function (Book $book) {
    $book->delete(); // Soft delete

    return redirect()->back()->with('status', 'Book deleted successfully.');
})->name('books.destroy');

// Route for displaying soft-deleted books
Route::get('/books/deleted', function () {
    $deletedBooks = Book::onlyTrashed()->get();
    return view('deleted', compact('deletedBooks'));
})->name('books.deleted');

// Route for restoring a soft-deleted book
// Uses Route Model Binding (Book $book) withTrashed to find deleted models
Route::put('/books/{book}/restore', function (Book $book) {
    // Ensure the book is found, including trashed ones
    $book = Book::withTrashed()->findOrFail($book->id);
    $book->restore();

    return redirect()->route('books.deleted')->with('status', 'Book restored successfully!');
})->name('books.restore');

// Placeholder routes for create/store/show if they had logic in the original controller
// If these methods had logic, it would be embedded here similarly.
/*
Route::get('/books/create', function () {
    // ... (logic from create method)
})->name('books.create');

Route::post('/books', function (Request $request) {
    // ... (logic from store method)
})->name('books.store');

Route::get('/books/{id}', function (string $id) {
    // ... (logic from show method)
})->name('books.show');
*/