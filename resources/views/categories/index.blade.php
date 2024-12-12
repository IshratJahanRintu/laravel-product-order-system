@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Categories</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Add Category</a>

        @if($categories->isEmpty())
            <div class="alert alert-info">
                No categories available. Please add a new category.
            </div>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
