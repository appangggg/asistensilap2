<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::all();
        return response()->json($genres, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string',
            'description' => 'required|string',
        ]);

        $genre = Genre::create($request->all());
        return response()->json($genre, 201);
    }

    public function show(string $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json(['message' => 'Genre not found'], 404);
        }

        return response()->json($genre, 200);
    }

    public function update(Request $request, string $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json(['message' => 'Genre not found'], 404);
        }

        $genre->update($request->all());
        return response()->json($genre, 200);
    }

    public function destroy(string $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json(['message' => 'Genre not found'], 404);
        }

        $genre->delete();
        return response()->json(['message' => 'Genre deleted successfully'], 200);
    }
}