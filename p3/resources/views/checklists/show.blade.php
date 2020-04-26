@extends('layouts.master')

@section('title')
{{ $checklist ? $checklist->title : 'Checklist not found' }}
@endsection

@section('content')

@if(!$checklist) 
    Checklist not found. <a href='/checklists'>See what checklists are available.</a>
@else
<h1>{{ $checklist->title }}</h1>
@endif

@if($checklist_items)
    <ul>
        @foreach($checklist_items as $item)
            <h4>{{ $item->item_number }}. {{ $item->item_name }}</h4>
            <p>{{ $item->plan_requirement }}</p>
        @endforeach
    </ul>
@endif

@if($checklist)
<a href='/checklists/{{ $checklist->id }}/edit'>Edit this Checklist</a>
<p><a href='/checklists/{{ $checklist->id }}/delete'>Delete this Checklist</a></p>
@endif

@endsection