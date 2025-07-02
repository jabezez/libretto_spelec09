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
            <div class="card-header">Genre List</div>
            
            <div class="card-body">
                <a href="{{ route('genres.create') }}" class="btn btn-success btn-sm my-2">
                    <i class="bi bi-plus-circle"></i> Add New Genre
                </a>

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">S#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($genres as $genre)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $genre->name }}</td>
                                <td>{{ $genre->created_at->format('M d, Y') }}</td>
                                <td>
                                    <form action="{{ route('genres.destroy', $genre->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <a href="{{ route('genres.show', $genre->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-eye"></i> Show
                                        </a>
                                        <a href="{{ route('genres.edit', $genre->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this genre?');">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <td colspan="4">
                                <span class="text-danger"><strong>No Genre Found!</strong></span>
                            </td>
                        @endforelse
                    </tbody>
                </table>

                {{ $genres->links() }}
            </div>
        </div>
    </div>
</div>
@endsection