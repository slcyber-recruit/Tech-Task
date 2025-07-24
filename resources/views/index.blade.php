@extends('layouts.app')

@section('content')
    <div class="row mb-3 search-bar">
        <div class="col-md-4 offset-md-8">
            {{-- Add a form for the search functionality --}}
            <form action="{{ route('books.index') }}" method="GET" class="d-flex">
                <input
                    type="text"
                    class="form-control me-2"
                    placeholder="Search by book title ..."
                    name="search" {{-- Add the name attribute --}}
                    value="{{ request('search') }}" {{-- Retain the search value --}}
                >
                <button type="submit" class="btn btn-secondary">Search</button> {{-- Add a search button --}}
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- Check if $books is not empty before looping --}}
                @if (count($books) > 0)
                    @foreach($books as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->rating }}</td>
                            <td>
                                {{-- Updated the Edit link to point to the dynamic route --}}
                                <a href="{{ route('books.edit', $book->id) }}" class="action-link">Edit</a>
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-link" onclick="return confirm('Are you sure?')">Delete</button>
                                </form> 
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center">No books found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection