@extends('layouts.app')

@section('title', 'Add Category')

@section('content')
    <div class="container">
        <h1>Add Category</h1>
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Category</button>
        </form>
    </div>
@endsection
