@extends('layout')
@section('title')
    Edit Book {{ $book->id }}
@endsection
@section('content')
    @include('inc.errors')
    <form method="POST" action="{{ route('books.update', $book->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-3">
            <input type="text" class="form-control" placeholder="Book Title" name="title"
                value="{{ old('title') ?? $book->title }}">
        </div>
        <div class="form-group mb-3">
            <textarea class="form-control" rows="3" placeholder="Book Description" name="desc">{{ old('desc') ?? $book->desc }}</textarea>
        </div>
        <div class="form-group mb-3">
            <input type="file" name="img" class="form-control-file">
        </div>
        Select Categories:
        @foreach ($categories as $category)
            <div class="form-check">
                <input name="category_ids[]" type="checkbox" class="form-check-input" value="{{ $category->id }}"
                    id="category_{{ $category->id }}">
                {{ $category->name }}
            </div>
        @endforeach
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
