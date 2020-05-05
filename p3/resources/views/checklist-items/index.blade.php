@extends('layouts.master')

@section('title')
    Inspection Items
@endsection

@section('content')
    <div id='newItem'>
        <h2><a href='/checklist-items/create'><button class='btn btn-primary'>Add a New Checklist Item</button></a></h2>
    </div>
<p></p>
    <div id='checklists'>
        <h3>Browse Existing Checklist Items</h3>
        @if(count($checklistItems) == 0) 
            No items have been added for potential inclusion in checklists yet...
        @else
        <ul>    
            @foreach($checklistItems as $item) 
                <h4>{{ $item->item_number }}. {{ $item->item_name }}</h4>
                <p>{{ $item->plan_requirement }}</p>
                <p><a href='/checklist-items/{{ $item->id }}/edit'>Edit this Item</a></p>
            @endforeach
        </ul>
        @endif
    </div>

@endsection