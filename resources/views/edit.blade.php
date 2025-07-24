<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Edit Book</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div id="app">
        <edit-book
            :book-id="{{ $book->id }}"
            title="{{ $book->title }}"
            author="{{ $book->author }}"
            :rating="{{ $book->rating }}"
        ></edit-book>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
