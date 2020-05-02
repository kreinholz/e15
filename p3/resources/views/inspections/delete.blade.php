@extends('layouts.master')

@section('title')
    Confirm deletion: Inspection of {{ $inspection->rail_transit_agency }} on {{ date('M d, Y', strtotime($inspection->inspection_date)) }}
@endsection

@section('content')
@if($user->job_title != 'Safety Oversight Manager' and $user->id != $inspection->inspector_id)
You do not have permission to delete this inspection!
@else
    <h1>Confirm deletion</h1>

    <p>Are you sure you want to delete this inspection?</p>
    <p>Inspection of {{ $inspection->rail_transit_agency }} on {{ date('M d, Y', strtotime($inspection->inspection_date)) }} by {{ $inspector->first_name }} {{ $inspector->last_name }}</p>

    <form method='POST' action='/inspections/{{ $inspection->id }}'>
        {{ method_field('delete') }}
        {{ csrf_field() }}
        <input type='submit' value='Yes, I want to delete it' class='btn btn-danger btn-small'>
    </form>
<p></p>
    <p class='cancel'>
        <a href='/inspections/{{ $inspection->id }}'>No, don't delete it.</a>
    </p>
@endif
@endsection