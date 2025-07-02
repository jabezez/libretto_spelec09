@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-3">
    <div class="col-md-12">
        @session('success')
            <div class="alert alert-success" role="alert">
                {{ $value }}
            </div>
        @endsession

        <div class="card">
            <div class="card-header">Reviews for "{{ $book->title }}"</div>
            
            <div class="card-body">
                <a href="{{ route('books.reviews.create', $book) }}" class="btn btn-success btn-sm my-2">
                    <i class="bi bi-plus-circle"></i> Add New Review
                </a>

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">S#</th>
                            <th scope="col">Content</th>
                            <th scope="col">Rating</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reviews as $review)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ Str::limit($review->content, 50) }}</td>
                                <td>{{ $review->rating }}/5</td>
                                <td>{{ $review->created_at->format('M d, Y') }}</td>
                                <td>
                                    <form action="{{ route('books.reviews.destroy', [$book, $review]) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <a href="{{ route('books.reviews.show', [$book, $review]) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-eye"></i> Show
                                        </a>
                                        <a href="{{ route('books.reviews.edit', [$book, $review]) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this review?');">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <td colspan="5">
                                <span class="text-danger"><strong>No Reviews Found!</strong></span>
                            </td>
                        @endforelse
                    </tbody>
                </table>

                {{ $reviews->links() }}

                <div class="mt-3">
                    <a href="{{ route('books.show', $book) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Book
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection