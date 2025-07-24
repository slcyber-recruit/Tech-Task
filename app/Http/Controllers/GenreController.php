<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
class GenreController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|unique:genres,name',
    ]);

    $genre = Genre::create($validated);

    return response()->json($genre, 201);
}
}
