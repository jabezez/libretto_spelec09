@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Edit Book</div>
            
            <div class="card-body">
                <form action="{{ route('books.update', $book->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $book->title) }}">
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="author_id" class="form-label">Author</label>
                        <select class="form-control @error('author_id') is-invalid @enderror" 
                                id="author_id" 
                                name="author_id">
                            <option value="">Select Author</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}" 
                                        {{ old('author_id', $book->author_id) == $author->id ? 'selected' : '' }}>
                                    {{ $author->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('author_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Genres</label>
                        @foreach($genres as $genre)
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       value="{{ $genre->id }}" 
                                       name="genres[]" 
                                       id="genre{{ $genre->id }}"
                                       {{ in_array($genre->id, old('genres', $book->genres->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <label class="form-check-label" for="genre{{ $genre->id }}">
                                    {{ $genre->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Update
                        </button>
                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection