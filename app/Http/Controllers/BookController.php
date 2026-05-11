<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('genre')->get();
        return response()->json($books, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string',
            'author'   => 'required|string',
            'year'     => 'required|integer',
            'genre_id' => 'required|exists:genres,id',
        ]);

        $book = Book::create($request->all());
        return response()->json($book->load('genre'), 201);
    }

    public function show(string $id)
    {
        $book = Book::with('genre')->find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json($book, 200);
    }

    public function update(Request $request, string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $book->update($request->all());
        return response()->json($book->load('genre'), 200);
    }

    public function destroy(string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $book->delete();
        return response()->json(['message' => 'Book deleted successfully'], 200);
    }
}