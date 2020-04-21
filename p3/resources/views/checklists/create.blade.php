@extends('layouts.master')

@section('title')
    Create a new Checklist
@endsection

@section('content')

    <h1>Create a new Checklist</h1>

    <p>This form will allow you to create a new checklist. Select the inspection items you want your checklist to contain.</p>

    <form method='POST' action='/checklists'>
        <div class='details'>* Required fields</div>
        {{ csrf_field() }}

        <label for='title'>Checklist Title</label>
        <input type='text' name='title' id='title' value='{{ old('title') }}'>
        @include('includes.error-field', ['fieldName' => 'title'])

        <label for='item_id'>Item</label>
        <select name='item_id'>
            <option value=''>Choose one...</option>
            @foreach($checklistItems as $item)
                <option value='{{ $item->id }}' {{ (old('item_id') == $item->item_id) ? 'selected' : '' }}>{{ $item->item_number.' '.$item->item_name.' - '.$item->plan_requirement }}</option>
            @endforeach
        </select>
        @include('includes.error-field', ['fieldName' => 'item_id'])

 <!-- This is where there should be a button to add an additional item, as many items as desired on the checklist -->

        <input type='submit' class='btn btn-primary' value='Create Checklist'>

    </form>

@endsection