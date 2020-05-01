@extends('layouts.master')

@section('title')
    Continue or Edit an Inspection
@endsection

@section('content')

    <h1>Continue or Edit an Inspection</h1>

    <p>This form will allow you to edit an in-progress or completed inspection. You can save your updates at any time--you do not need to complete the writeup for every inspection item prior to saving your changes. When you're satisfied this inspection is complete, please check the box to indicate the inspection is complete.</p>

    <form method='POST' action='/inspections/{{ $inspection->id }}'>
        <div class='details'>* Required fields</div>
        {{ csrf_field() }}
        {{  method_field('put') }}

        <label for='rail_transit_agency'>* Rail Transit Agency Being Inspected</label>
        <input type='text' name='rail_transit_agency' id='rail_transit_agency' value='{{ old('rail_transit_agency', $inspection->rail_transit_agency) }}'>
        @include('includes.error-field', ['fieldName' => 'rail_transit_agency'])

        <label for='inspection_date'>* Date of Inspection</label>
        <input type='date' name='inspection_date' id='inspection_date' value='{{ old('inspection_date', $inspection->inspection_date) }}'>
        @include('includes.error-field', ['fieldName' => 'inspection_date'])

        <label for='inspection_items'>Inspection Items</label>
        @foreach($inspectionItems as $item)
            <p></p>
            <h4>{{ $item->item_number }}. {{ $item->item_name }}</h4>
            <p>{{ $item->plan_requirement }}
            <!-- boxes should start checked or unchecked depending on what's stored in the database -->
            <input type='checkbox' name='included[]' value='{{ $item->included }}' @if($item->included) checked @endif>
            <p></p>
            <label for='page_reference'>Page Reference</label>
            <input type='text' name='page_reference[]' value='{{ old('item->page_reference', $item->page_reference) }}'>
            @include('includes.error-field', ['fieldName' => 'page_reference'])
            <label for='comments'>Comments</label>
            <textarea name='comments[]'>{{ old('item->comments', $item->comments) }}</textarea>
            @include('includes.error-field', ['fieldName' => 'comments'])
            <p></p>
        @endforeach
        <p></p>
        <input type='checkbox' name='completed' value='{{ $inspection->completed }}' @if($inspection->completed) checked @endif>This Inspection is Complete (Finalize Inspection).
        <p></p>
        <input type='submit' class='btn btn-primary' value='Save Changes'>

    </form>
<p></p>

@endsection