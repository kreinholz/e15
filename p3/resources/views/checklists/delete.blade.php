@extends('layouts.master')

@section('title')
    Confirm deletion: {{ $checklist->title }}
@endsection

@section('content')

    <h1>Confirm deletion</h1>

    <p>Are you sure you want to delete the checklist <strong>{{ $checklist->title }}</strong>?</p>

    <form method='POST' action='/checklists/{{ $checklist->id }}'>
        {{ method_field('delete') }}
        {{ csrf_field() }}
        <input type='submit' value='Yes, I want to delete it' class='btn btn-danger btn-small'>
    </form>
<p></p>
    <p class='cancel'>
        <a href='/checklists/{{ $checklist->id }}'>No, don't delete it.</a>
    </p>

@endsection