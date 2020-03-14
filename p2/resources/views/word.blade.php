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
    <input type='text' id='inputString' name='inputString' value='{{ $inputString }}'>
    <p></p>
    <input type='checkbox' id='specialChars' name='specialChars' value='specialChars' {{ $specialChars ? 'checked' : '' }}>
    <label for='specialChars'> Include words with special characters?</label>
    <p></p>
    <label for='alphabetical'>Sort results alphabetically or reverse alphabetically?</label>
    <select name='alphabetical'>
        <option value='alpha' {{ ($alphabetical == 'alpha') ? 'selected' : '' }}>Alphabetical</option>
        <option value='reverse' {{ ($alphabetical == 'reverse') ? 'selected' : '' }}>Reverse Alphabetical</option>
    </select>
    <p></p>
    <label for='length'>Display results shortest to longest or longest to shortest?</label>
    <select name='length'>
        <option value='shortest' {{ ($length == 'shortest') ? 'selected' : '' }}>Shortest to Longest</option>
        <option value='longest' {{ ($length == 'longest') ? 'selected' : '' }}>Longest to Shortest</option>
    </select>
    <p></p>
    <button type='submit'>Find Words</button>
</form>
<p></p>
@if($searchResults)
<ul>
    @foreach ($searchResults as $word)
        <li>{{ $word }}</li>
    @endforeach
</ul>
@endif
@endsection