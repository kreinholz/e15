@extends('word')

@section('form')
<form method='POST' action='process.php'>
    <label for='inputString'>Your letters/characters:</label>
    <input type='text' id='inputString' name='inputString'>
    <p></p>
    <input type='checkbox' id='specialChars' name='specialChars'>
    <label for='specialChars'> Include words with special characters?</label>
    <p></p>
    <label for='alphabetical'>Sort results alphabetically or reverse alphabetically?</label>
    <select id='alphabetical'>
        <option value='alpha'>Alphabetical</option>
        <option value='reverse'>Reverse Alphabetical</option>
    </select>
    <p></p>
    <label for='length'>Display results shortest to longest or longest to shortest?</label>
    <select id='length'>
        <option value='shortest'>Shortest to Longest</option>
        <option value='longest'>Longest to Shortest</option>
    </select>
    <p></p>
    <button type='submit'>Find Words</button>
</form>
@endsection