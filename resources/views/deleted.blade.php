<!-- resources/views/books/deleted.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Deleted Books</h1>

        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if($deletedBooks->isEmpty())
            <p>No deleted books.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Rating</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deletedBooks as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->rating }}</td>
                            <td>
                                <form action="{{ route('books.restore', $book->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-success">Undo Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('books.index') }}" class="btn btn-secondary">Back to Book List</a>
    </div>
@endsection
