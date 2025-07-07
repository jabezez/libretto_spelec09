<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{
    public function index(): JsonResponse
    {
        $authors = Author::with('books')->get();
        
        return response()->json([
            'success' => true,
            'data' => $authors,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:authors,name'
        ]);

        $author = Author::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Author created successfully!',
            'data' => $author
        ], 201);
    }

    public function show(Author $author): JsonResponse
    {
        $author->load(['books.genres', 'books.reviews']);
        
        return response()->json([
            'success' => true,
            'data' => $author
        ]);
    }

    public function update(Request $request, Author $author): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:authors,name,' . $author->id
        ]);

        $author->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Author updated successfully!',
            'data' => $author
        ]);
    }

    public function destroy(Author $author): JsonResponse
    {
        try {
            $author->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Author deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete author. Please remove associated books first.'
            ], 422);
        }
    }
}