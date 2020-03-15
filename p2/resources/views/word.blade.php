@extends('layouts.master')

@section('title')
P2 - Word Finder
@endsection

@section('content')
<p>
    Enter a word or a string of characters to find English language words that can be made out of them.
</p>

<form method='GET' action='/process'>
    <label for='inputString'>Your letters/characters:</label>
    <input type='text' id='inputString' name='inputString' value='{{ old('inputString', $inputString) }}'> 
    <p></p>    
    @if($errors->get('inputString'))
        <div class='error'>One or more alphabetical characters are required.</div>
        <p></p>
    @endif
    <input type='checkbox' id='reuse' name='reuse' value='reuse' {{ (old('reuse') or $reuse) ? 'checked' : '' }}>
    <label for='reuse'> Allow reuse of your letters (e.g. "ban" would match "banana")?</label>
    <p></p>
    <label for='alphabetical'>Sort results alphabetically or reverse alphabetically?</label>
    <select name='alphabetical'>
        <option value='alpha' {{ (old('alphabetical') == 'alpha' or $alphabetical == 'alpha') ? 'selected' : '' }}>Alphabetical</option>
        <option value='reverse' {{ (old('alphabetical') == 'reverse' or $alphabetical == 'reverse') ? 'selected' : '' }}>Reverse Alphabetical</option>
    </select>
    <p></p>
    <label for='length'>Display results shortest to longest or longest to shortest?</label>
    <select name='length'>
        <option value='shortest' {{ (old('length') == 'shortest' or $length == 'shortest') ? 'selected' : '' }}>Shortest to Longest</option>
        <option value='longest' {{ (old('length') == 'longest' or $length == 'longest') ? 'selected' : '' }}>Longest to Shortest</option>
    </select>
    <p></p>
    <button type='submit'>Find Words</button>
</form>
<p></p>
@if($searchResults)
<h2>English dictionary words that can be made from your input</h2>
<p>{{ count($searchResults) }} dictionary entries found:</p>
<ul>
    @foreach ($searchResults as $word)
        <li>{{ strtolower($word) }}</li>
    @endforeach
</ul>
<p></p>
@endif
@endsection