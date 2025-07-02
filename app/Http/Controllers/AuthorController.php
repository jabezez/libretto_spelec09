<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    
    public function index()
    {
        $authors = Author::with('books')->paginate(10);
        return view('authors.index', compact('authors'));
    }

    public function create()
    {
        return view('authors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:authors,name'
        ]);

        $author = Author::create($validated);

        return redirect()->route('authors.index')
            ->with('success', 'Author created successfully!');
    }

    public function show(Author $author)
    {
        $author->load(['books.genres', 'books.reviews']);
        return view('authors.show', compact('author'));
    }

    
    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:authors,name,' . $author->id
        ]);

        $author->update($validated);

        return redirect()->route('authors.index')
            ->with('success', 'Author updated successfully!');
    }

    public function destroy(Author $author)
    {
        try {
            $author->delete();
            return redirect()->route('authors.index')
                ->with('success', 'Author deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('authors.index')
                ->with('error', 'Cannot delete author. Please remove associated books first.');
        }
    }
}