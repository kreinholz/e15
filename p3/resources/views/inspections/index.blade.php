@extends('layouts.master')

@section('title')
    Inspections
@endsection

@section('content')

    <div id='checklists'>
        <h2>Completed/In-Progress Inspections</h2>
        @if($user->job_title == 'Safety Oversight Manager')
            @if(count($inspections) == 0) 
                No inspections have been started yet...
            @else
            <ul>    
                @foreach($inspections as $inspection)
                    @if($inspection->completed == true)
                    <li><a href='/inspections/{{ $inspection->id }}'>Inspection of {{ $inspection->rail_transit_agency }} on {{ $inspection->inspection_date }} (Completed)</a></li>
                    @else
                    <li><a href='/inspections/{{ $inspection->id }}/edit'>Inspection of {{ $inspection->rail_transit_agency }} on {{ $inspection->inspection_date }} (In-Progress)</a></li>
                    @endif
                @endforeach
            </ul>
            @endif
        @elseif(count($myInspections) == 0)
            You have not saved any inspections yet...
        @else
        <ul>    
            @foreach($myInspections as $inspection) 
                @if($inspection->completed == true)
                <li><a href='/inspections/{{ $inspection->id }}'>Inspection of {{ $inspection->rail_transit_agency }} on {{ $inspection->inspection_date }} (Completed)</a></li>
                @else
                <li><a href='/inspections/{{ $inspection->id }}/edit'>Inspection of {{ $inspection->rail_transit_agency }} on {{ $inspection->inspection_date }} (In-Progress)</a></li>
                @endif
            @endforeach
        </ul>
        @endif
    </div>
<p></p>
@endsection