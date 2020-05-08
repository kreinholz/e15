@extends('layouts.master')

@section('title')
    Start a New Agency Safety Plan Review
@endsection

@section('content')

    <h1>Start a New Agency Safety Plan Review</h1>

    @if(count($checklists) > 0) 
    <p>This form will allow you to start a new Agency Safety Plan Review. Select the checklist you want to use for this Agency Safety Plan Review.</p>

    <form method='POST' action='/inspections'>
        <div class='details'>* Required fields</div>
        {{ csrf_field() }}

        <label for='rail_transit_agency'>* Rail Transit Agency Being Reviewed</label>
        <input type='text' name='rail_transit_agency' id='rail_transit_agency' value='{{ old('rail_transit_agency') }}'>
        @include('includes.error-field', ['fieldName' => 'rail_transit_agency'])

        <label for='inspection_date'>* Date of Agency Safety Plan Review</label>
        <input type='date' name='inspection_date' id='inspection_date' value='{{ old('inspection_date') }}'>
        @include('includes.error-field', ['fieldName' => 'inspection_date'])

        <label for='checklist'>* Checklist to run</label>
        <select name='checklist' id='checklist'>
            @foreach($checklists as $checklist)
            <option value='{{ $checklist->id }}'>{{ $checklist->title }}</option>
            @endforeach
        </select>

        <input type='submit' class='btn btn-primary' value='Create Inspection'>

    </form>
    @else
    There are no checklists available from which to begin a new Agency Safety Plan Review. Please ask the Safety Oversight Manager to create a checklist and then try again.
    @endif
    <p></p>

@endsection