@extends('layouts.app')

@section('content')

<div class="row justify-content-center mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Author Details</div>
            
            <div class="card-body">
                <div class="mb-3">
                    <strong>Name:</strong> {{ $author->name }}
                </div>
                <div class="mb-3">
                    <strong>Created At:</strong> {{ $author->created_at->format('M d, Y') }}
                </div>
                <div class="mb-3">
                    <strong>Updated At:</strong> {{ $author->updated_at->format('M d, Y') }}
                </div>

                <h5>Books by {{ $author->name }}</h5>
                @if($author->books->count() > 0)
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">S#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Genres</th>
                                <th scope="col">Reviews</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($author->books as $book)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $book->title }}</td>
                                    <td>
                                        @forelse($book->genres as $genre)
                                            <span class="badge bg-secondary">{{ $genre->name }}</span>
                                        @empty
                                            <span class="text-muted">No genres</span>
                                        @endforelse
                                    </td>
                                    <td>{{ $book->reviews->count() }} reviews</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">This author hasn't written any books yet.</p>
                @endif

                <div class="mt-3">
                    <a href="{{ route('authors.edit', $author->id) }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <a href="{{ route('authors.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection