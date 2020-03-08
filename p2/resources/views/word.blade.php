@extends('layouts.master')

@section('title')
P2 - Word Finder
@endsection

@section('head')
{{-- Page specific CSS includes should be defined here; this .css file does not exist yet, but we can create it --}}
@endsection

@section('content')
<p>
    Enter a word or a string of characters to find English language words that can be made out of them.
</p>

<section>
    @yield('form')
</section>
<p></p>
@endsection