@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Review Details</div>
            
            <div class="card-body">
                <div class="mb-3">
                    <strong>Book:</strong> {{ $book->title }}
                </div>
                <div class="mb-3">
                    <strong>Author:</strong> {{ $book->author->name }}
                </div>
                <div class="mb-3">
                    <strong>Rating:</strong> {{ $review->rating }}/5
                </div>
                <div class="mb-3">
                    <strong>Review Content:</strong>
                    <p class="mt-2">{{ $review->content }}</p>
                </div>
                <div class="mb-3">
                    <strong>Created At:</strong> {{ $review->created_at->format('M d, Y') }}
                </div>
                <div class="mb-3">
                    <strong>Updated At:</strong> {{ $review->updated_at->format('M d, Y') }}
                </div>

                <div class="mt-3">
                    <a href="{{ route('books.reviews.edit', [$book, $review]) }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <a href="{{ route('books.reviews.index', $book) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection