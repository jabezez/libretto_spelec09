@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Genre Details</div>
            
            <div class="card-body">
                <div class="mb-3">
                    <strong>Name:</strong> {{ $genre->name }}
                </div>
                <div class="mb-3">
                    <strong>Created At:</strong> {{ $genre->created_at->format('M d, Y') }}
                </div>
                <div class="mb-3">
                    <strong>Updated At:</strong> {{ $genre->updated_at->format('M d, Y') }}
                </div>

                <h5>Books in {{ $genre->name }} Genre ({{ $genre->books->count() }})</h5>
                @if($genre->books->count() > 0)
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">S#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Author</th>
                                <th scope="col">Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($genre->books as $book)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $book->title }}</td>
                                    <td>{{ $book->author->name }}</td>
                                    <td>{{ $book->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">No books in this genre yet.</p>
                @endif

                <div class="mt-3">
                    <a href="{{ route('genres.edit', $genre->id) }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <a href="{{ route('genres.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection