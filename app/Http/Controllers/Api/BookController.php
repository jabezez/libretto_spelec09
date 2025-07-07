<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class BookController extends Controller
{
    public function index(): JsonResponse
    {
        $books = Book::with(['author', 'genres', 'reviews'])->latest()->get();
        
        return response()->json([
            'success' => true,
            'data' => $books,
        ]);
    }
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id'
        ]);

        $book = Book::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Book created successfully!',
            'data' => $book

        ], 201);
    }

    public function show(Book $book): JsonResponse
    {
        $book->load(['author', 'genres', 'reviews']);
        
        return response()->json([
            'success' => true,
            'data' => $book
        ]);
    }
    public function destroy(Book $book): JsonResponse
    {
        try {
            $book->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Book deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete book. Please remove associated data first.'
            ], 422);
        }
    }

}
