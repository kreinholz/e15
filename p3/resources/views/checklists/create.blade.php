@extends('layouts.master')

@section('title')
    Create a new Checklist
@endsection

@section('content')

    <h1>Create a new Checklist</h1>

    <p>This form will allow you to create a new checklist. Select the Agency Safety Plan Review items you want your checklist to contain.</p>

    <form method='POST' action='/checklists'>
        <div class='details'>* Required fields</div>
        {{ csrf_field() }}

        <label for='title'>* Checklist Title</label>
        <input type='text' name='title' id='title' value='{{ old('title') }}'>
        @include('includes.error-field', ['fieldName' => 'title'])
    @if(!$checklistItems)
    No items have been added for potential inclusion in checklists. Click <a href='/checklist-items'>here</a> to create new items for inclusion in checklists.
    @else
        <label for='checklist_items'>Available Checklist Items</label>
        @foreach($checklistItems as $item)
            <h4>{{ $item->item_number }}. {{ $item->item_name }}</h4>
            <p>{{ $item->plan_requirement }}<br>
            <!-- checkboxes remaining checked upon validation failure comes from https://stackoverflow.com/a/39524462 -->
            <input type='checkbox' name='checklist_items[]' value='{{ $item->id }}' @if(is_array(old('checklist_items')) && in_array($item->id, old('checklist_items'))) checked @endif>Add this item to checklist</p>
        @endforeach

        <input type='submit' class='btn btn-primary' value='Create Checklist'>

    </form>
    <p></p>
    <p>Want to add a question/item that isn't included in the above list? Click <a href='/checklist-items'>here</a> to create new items for inclusion in checklists.</p>
    @endif
@endsection