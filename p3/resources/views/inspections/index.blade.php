@extends('layouts.master')

@section('title')
    Inspections
@endsection

@section('content')

    <div id='checklists'>
        <h2>Completed/In-Progress Inspections</h2>
        @if(count($inspections) == 0) 
            No inspections have been started yet...
        @else
        <ul>    
            @foreach($inspections as $inspection) 
                <li><a href='/inspections/{{ $inspection->id }}'>{{ $inspection->date }} of {{ $inspection->rail_transit_authority }} on {{ $inspection->inspection_date }}</a></li>
            @endforeach
        </ul>
        @endif
    </div>

@endsection