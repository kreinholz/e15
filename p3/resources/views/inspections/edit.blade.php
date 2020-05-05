@extends('layouts.master')

@section('title')
    Continue or Edit an Agency Safety Plan Review
@endsection

@section('content')

@if(!$inspection)
Agency Safety Plan Review not found. <a href='/inspections'>See what Agency Safety Plan Reviews are available.</a>
@elseif($user->job_title != 'Safety Oversight Manager' and $user->id != $inspection->inspector_id)
Sorry, you don't have permission to edit this inspection.
@else

    <h1>Continue or Edit an Agency Safety Plan Review</h1>

    <p>This form will allow you to edit an in-progress or completed Agency Safety Plan Review. You can save your updates at any time--you do not need to complete the writeup for every item prior to saving your changes. When you're satisfied this Agency Safety Plan Review is complete, please check the box to indicate it is complete.</p>

    <form method='POST' action='/inspections/{{ $inspection->id }}'>
        <div class='details'>* Required fields</div>
        {{ csrf_field() }}
        {{  method_field('put') }}

        <label for='rail_transit_agency'>* Rail Transit Agency Being Reviewed</label>
        <input type='text' name='rail_transit_agency' id='rail_transit_agency' value='{{ old('rail_transit_agency', $inspection->rail_transit_agency) }}'>
        @include('includes.error-field', ['fieldName' => 'rail_transit_agency'])

        <label for='inspection_date'>* Date of Agency Safety Plan Review</label>
        <input type='date' name='inspection_date' id='inspection_date' value='{{ old('inspection_date', $inspection->inspection_date) }}'>
        @include('includes.error-field', ['fieldName' => 'inspection_date'])

        <label for='inspection_items'>Agency Safety Plan Review Items</label>
        @foreach($inspectionItems as $item)
            <p></p>
            <h4>{{ $item->item_number }}. {{ $item->item_name }}</h4>
            <p>{{ $item->plan_requirement }}
            <!-- boxes should start checked or unchecked depending on what's stored in the database -->
            <input type='checkbox' name='includeds[{{ $item->id }}]' value='{{ $item->id }}' @if($item->included) checked @endif>
            <p></p>
            <label for='page_reference'>Page Reference</label>
            <input type='text' name='page_references[{{ $item->id }}]' value='{{ old('item->page_reference', $item->page_reference) }}'>
            @include('includes.error-field', ['fieldName' => 'page_reference'])
            <label for='comments'>Comments</label>
            <textarea name='comments[{{ $item->id }}]'>{{ old('item->comments', $item->comments) }}</textarea>
            @include('includes.error-field', ['fieldName' => 'comments'])
            <p></p>
        @endforeach
        <p></p>
        <input type='checkbox' name='completed' value='{{ $inspection->id }}' @if($inspection->completed) checked @endif>This Agency Safety Plan Review is Complete.
        <p></p>
        <input type='submit' class='btn btn-primary' value='Save Changes'>

    </form>
<p></p>
<p><a href='/inspections/{{ $inspection->id }}'>Preview the report for this Agency Safety Plan Review</a></p>
<p><a href='/inspections/{{ $inspection->id }}/delete'><button class='btn btn-danger'>Delete this Agency Safety Plan Review</button></a></p>
@endif
@endsection