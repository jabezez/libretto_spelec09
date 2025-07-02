<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Book;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Book $book)
    {
        $reviews = $book->reviews()->latest()->paginate(10);
        return view('reviews.index', compact('reviews', 'book'));
    }

    public function create(Book $book)
    {
        return view('reviews.create', compact('book'));
    }

    public function store(Request $request, Book $book)
    {
        $request->validate([
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $book->reviews()->create($request->only(['content', 'rating']));

        return redirect()->route('books.reviews.index', $book)->with('success', 'Review created successfully!');
    }

    public function show(Book $book, Review $review)
    {
        return view('reviews.show', compact('review', 'book'));
    }

    public function edit(Book $book, Review $review)
    {
        return view('reviews.edit', compact('review', 'book'));
    }

    public function update(Request $request, Book $book, Review $review)
    {
        $request->validate([
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $review->update($request->only(['content', 'rating']));

        return redirect()->route('books.reviews.index', $book)->with('success', 'Review updated successfully!');
    }

    public function destroy(Book $book, Review $review)
    {
        $review->delete();
        return redirect()->route('books.reviews.index', $book)->with('success', 'Review deleted successfully!');
    }
}