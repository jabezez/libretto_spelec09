@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Add Review for "{{ $book->title }}"</div>
            
            <div class="card-body">
                <form action="{{ route('books.reviews.store', $book) }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="content" class="form-label">Review Content</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" 
                                  name="content" 
                                  rows="5">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating</label>
                        <select class="form-control @error('rating') is-invalid @enderror" 
                                id="rating" 
                                name="rating">
                            <option value="">Select Rating</option>
                            <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>1 - Poor</option>
                            <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>2 - Fair</option>
                            <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>3 - Good</option>
                            <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>4 - Very Good</option>
                            <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>5 - Excellent</option>
                        </select>
                        @error('rating')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Save
                        </button>
                        <a href="{{ route('books.reviews.index', $book) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection