@extends('layouts.master')

@section('title')
    Inspection Checklists
@endsection

@section('content')

    <div id='checklists'>
        <h2>Available Checklists</h2>
        @if(count($checklists) == 0) 
            No checklists have been added yet...
        @else
        <ul>    
            @foreach($checklists as $checklist) 
                <li><a href='/checklists/{{ $checklist->id }}'>{{ $checklist->title }}</a></li>
            @endforeach
        </ul>
        @endif
    </div>

@endsection