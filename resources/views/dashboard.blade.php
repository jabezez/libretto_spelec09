@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header text-center">Dashboard</div>
            
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('books.index') }}" class="btn btn-primary btn-lg w-100">
                            Books
                        </a>
                    </div>

                    <div class="col-md-4 mb-3">
                        <a href="{{ route('authors.index') }}" class="btn btn-success btn-lg w-100">
                            Authors
                        </a>
                    </div>

                    <div class="col-md-4 mb-3">
                        <a href="{{ route('genres.index') }}" class="btn btn-warning btn-lg w-100">
                            Genres
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection