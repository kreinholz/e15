@extends('layouts.master')

@section('content')
<p>
    @if(Auth::user() && Auth::user()->job_title == 'Safety Oversight Manager')
    Welcome back, {{ $userName }}. This is the (experimental) WisDOT Rail Transit Safety Oversight electronic inspections of Rail Transit Agency Safety Plans application. Here, you can view open/completed safety plan inspections, start a new inspection, view inspection checklists, or create new checklists.
    @elseif(Auth::user())
    Welcome back, {{ $userName }}. This is the (experimental) WisDOT Rail Transit Safety Oversight electronic inspections of Rail Transit Agency Safety Plans application. Here, you can view open/completed safety plan inspections or start a new inspection.
    @else
    Welcome to the (experimental) WisDOT Rail Transit Safety Oversight electronic inspections of Rail Transit Agency Safety Plans application. You can either view a PDF of the RTA Safety Plan Checklist, or <a href='/login'>login</a> for more features.
    @endif
</p>

@endsection