@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Book Details</div>
            
            <div class="card-body">
                <div class="mb-3">
                    <strong>Title:</strong> {{ $book->title }}
                </div>
                <div class="mb-3">
                    <strong>Author:</strong> {{ $book->author->name }}
                </div>
                <div class="mb-3">
                    <strong>Genres:</strong> 
                    @forelse($book->genres as $genre)
                        {{ $genre->name }}@if(!$loop->last), @endif
                    @empty
                        No genres
                    @endforelse
                </div>
                <div class="mb-3">
                    <strong>Created At:</strong> {{ $book->created_at->format('M d, Y') }}
                </div>
                <div class="mb-3">
                    <strong>Updated At:</strong> {{ $book->updated_at->format('M d, Y') }}
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Reviews ({{ $book->reviews->count() }})</h5>
                    <div>
                        <a href="{{ route('books.reviews.create', $book) }}" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-circle"></i> Add Review
                        </a>
                        <a href="{{ route('books.reviews.index', $book) }}" class="btn btn-info btn-sm">
                            <i class="bi bi-list"></i> View All Reviews
                        </a>
                    </div>
                </div>
                @if($book->reviews->count() > 0)
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">S#</th>
                                <th scope="col">Content</th>
                                <th scope="col">Rating</th>
                                <th scope="col">Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($book->reviews as $review)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ Str::limit($review->content, 50) }}</td>
                                    <td>{{ $review->rating }}/5</td>
                                    <td>{{ $review->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">No reviews yet.</p>
                @endif

                <div class="mt-3">
                    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <a href="{{ route('books.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection