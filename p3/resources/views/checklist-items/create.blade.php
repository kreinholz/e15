@extends('layouts.master')

@section('title')
    Add a New Checklist Item
@endsection

@section('content')

    <h1>Add a New Item for Potential Inclusion in Checklists</h1>

    <p>This form will allow you to create a new checklist item.</p>

    <form method='POST' action='/checklist-items'>
        <div class='details'>* Required fields</div>
        {{ csrf_field() }}

        <label for='item_number'>* Item Number (must be a number)</label>
        <input type='text' name='item_number' id='item_number' value='{{ old('item_number') }}'>
        @include('includes.error-field', ['fieldName' => 'item_number'])

        <label for='item_name'>* Item Name</label>
        <input type='text' name='item_name' id='item_name' value='{{ old('item_name') }}'>
        @include('includes.error-field', ['fieldName' => 'item_name'])      
        
        <label for='plan_requirement'>* Plan Requirement (description)</label>
        <input type='text' name='plan_requirement' id='plan_requirement' value='{{ old('plan_requirement') }}'>
        @include('includes.error-field', ['fieldName' => 'plan_requirement'])

        <input type='submit' class='btn btn-primary' value='Add New Item'>

    </form>
<p></p>
@endsection

<!-- 'item_name' 'plan_requirement' -->