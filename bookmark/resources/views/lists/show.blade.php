@extends('layouts.master')

@section('head')
    <link href='/css/lists/show.css' rel='stylesheet'>
@endsection

@section('title')
    My List
@endsection

@section('content')

    <h1>My List</h1>
    @if($books->count() == 0)
        <p>You have not added any books to your list yet.</p>
        <p>Start building your list by checking out the <a href='/books'>books in our library...</a></p>
    @else

        @foreach($books as $book)
        <div class='book'>
            <a href='/books/{{ $book->slug }}'><h2>{{ $book->title }}</h2></a>
            @if($book->author)
                <p>By {{ $book->author->first_name. ' ' . $book->author->last_name }}</p>
            @endif

            <form method='POST' action='/list/{{ $book->slug }}'>
                {{ csrf_field() }}

                {{  method_field('put') }}
                <textarea name='notes' class='notes'>{{ $book->pivot->notes }}</textarea>
                <input type='submit' class='btn btn-primary' value='Update notes'>
            </form>

            <p class='added'>
                Added to your list {{ $book->pivot->created_at->diffForHumans() }}
            </p>

            <form method='POST' action='/list/{{ $book->slug }}'>
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <input type='submit' value='Remove from your list'>
            </form>

        </div>
        @endforeach

    @endif

@endsection
