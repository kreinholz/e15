@extends('layouts.master')

@section('title')
    Edit Checklist
@endsection

@section('content')
    @if(!$checklist)
    Checklist not found. <a href='/checklists'>See what checklists are available.</a>
    @else
    <h1>Edit Existing Checklist</h1>

    <p>This form will allow you to edit an existing checklist. Select the Agency Safety Plan Review items you want your checklist to contain, or deselect those you want to remove.</p>

    <form method='POST' action='/checklists/{{ $checklist->id }}'>
        <div class='details'>* Required fields</div>
        {{ csrf_field() }}
        {{  method_field('put') }}

        <label for='title'>Checklist Title</label>
        <input type='text' name='title' id='title' value='{{ old('title', $checklist->title) }}'>
        @include('includes.error-field', ['fieldName' => 'title'])

        <label for='existing_items'>Checklist Items Currently in Checklist</label>
        @foreach($existingItems as $item)
            <h4>{{ $item->item_number }}. {{ $item->item_name }}</h4>
            <p>{{ $item->plan_requirement }}<br>
            <!-- since all of these items are already stored in the databases, boxes should begin checked unless unchecked by the user -->
            <input type='checkbox' name='existing_items[]' value='{{ $item->id }}' checked>Uncheck to remove this item from checklist</p>
        @endforeach

        <label for='new_items'>Checklist Items Not Currently Included in Checklist</label>
        @foreach($newItems as $item)
            <h4>{{ $item->item_number }}. {{ $item->item_name }}</h4>
            <p>{{ $item->plan_requirement }}<br>
            <!-- checkboxes remaining checked upon validation failure comes from https://stackoverflow.com/a/39524462 -->
            <input type='checkbox' name='new_items[]' value='{{ $item->id }}' @if(is_array(old('new_items')) && in_array($item->id, old('new_items'))) checked @endif>Check to add this item to checklist</p>
        @endforeach

        <input type='submit' class='btn btn-primary' value='Update Checklist'>

    </form>
<p></p>
    <p>Want to add a question/item that isn't included in the above list? Click <a href='/checklist-items'>here</a> to create new items for inclusion in checklists.</p>
    @endif
@endsection