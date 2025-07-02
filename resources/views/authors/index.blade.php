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
            <div class="card-header">Author List</div>
            
            <div class="card-body">
                <a href="{{ route('authors.create') }}" class="btn btn-success btn-sm my-2">
                    <i class="bi bi-plus-circle"></i> Add New Author
                </a>

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">S#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Books Count</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($authors as $author)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $author->name }}</td>
                                <td>{{ $author->books->count() }}</td>
                                <td>{{ $author->created_at->format('M d, Y') }}</td>
                                <td>
                                    <form action="{{ route('authors.destroy', $author->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <a href="{{ route('authors.show', $author->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-eye"></i> Show
                                        </a>
                                        <a href="{{ route('authors.edit', $author->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this author?');">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <td colspan="5">
                                <span class="text-danger"><strong>No Author Found!</strong></span>
                            </td>
                        @endforelse
                    </tbody>
                </table>

                {{ $authors->links() }}
            </div>
        </div>
    </div>
</div>
@endsection