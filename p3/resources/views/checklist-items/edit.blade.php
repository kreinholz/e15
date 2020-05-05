@extends('layouts.master')

@section('title')
    Edit Checklist Item
@endsection

@section('content')
    @if(!$item)
    Checklist Item not found. <a href='/checklist-items'>See what checklist items are available.</a>
    @else
    <h1>Edit Checklist Item</h1>

    <p>This form will allow you to edit an existing checklist item.</p>

    <form method='POST' action='/checklist-items/{{ $item->id }}'>
        <div class='details'>* Required fields</div>
        {{ csrf_field() }}
        {{  method_field('put') }}

        <label for='item_number'>Item Number (must be a number between 1 and 127)</label>
        <input type='text' name='item_number' id='item_number' value='{{ old('item_number', $item->item_number) }}'>
        @include('includes.error-field', ['fieldName' => 'item_number'])

        <label for='item_name'>Item Name</label>
        <input type='text' name='item_name' id='item_name' value='{{ old('item_name', $item->item_name) }}'>
        @include('includes.error-field', ['fieldName' => 'item_name'])      
        
        <label for='plan_requirement'>Plan Requirement (description)</label>
        <input type='text' name='plan_requirement' id='plan_requirement' value='{{ old('plan_requirement', $item->plan_requirement) }}'>
        @include('includes.error-field', ['fieldName' => 'plan_requirement'])

        <input type='submit' class='btn btn-primary' value='Update Checklist Item'>

    </form>
    <form method='POST' action='/checklist-items/{{ $item->id }}'>
        {{ method_field('delete') }}
        {{ csrf_field() }}
        <input type='submit' value='Delete Checklist Item' class='btn btn-danger btn-small'>
    </form>
<p></p>
@endif
@endsection