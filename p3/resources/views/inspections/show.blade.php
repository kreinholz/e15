@extends('layouts.master')

@section('title')
{{ $inspection ? $inspection->rail_transit_agency : 'Inspection not found' }}
@endsection

@section('content')

@if(!$inspection) 
    Inspection not found. <a href='/inspections'>See what inspections are available.</a>
@else
<h1>Inspection of {{ $inspection->rail_transit_agency }} on {{ $inspection->inspection_date }} by {{ $inspector->first_name }} {{ $inspector->last_name }}</h1>
@endif

@if($inspection_items)
    <ul>
        @foreach($inspection_items as $item)
            <h4>{{ $item->item_number }}. {{ $item->item_name }}</h4>
            <p>{{ $item->plan_requirement }}</p>
            <p>
            @if($item->included == true)
                Included: ✓
            @else
                Included: ✗
            @endif
            Page Reference: {{ $item->page_reference }}
            </p>
            <p>Comments:</p>
            <p>{{ $item->comments }}</p>
        @endforeach
    </ul>
@endif

@if($inspection)
<p><a href='/inspections/{{ $inspection->id }}/edit'>Edit this Inspection</a></p>
<p><a href='/inspections/{{ $inspection->id }}/delete'>Delete this Inspection</a></p>
@endif

@endsection