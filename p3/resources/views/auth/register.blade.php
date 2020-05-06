@extends('layouts.master')

@section('content')
    <h1>Register</h1>

    Already have an account? <a href='/login'>Login here...</a>

    <form method='POST' action='{{ route('register') }}'>
        {{ csrf_field() }}

        <label for='first_name'>First Name</label>
        <input id='first_name' type='text' name='first_name' value='{{ old('first_name') }}' required autofocus>
        @include('includes.error-field', ['fieldName' => 'first_name'])

        <label for='last_name'>Last Name</label>
        <input id='last_name' type='text' name='last_name' value='{{ old('last_name') }}' required autofocus>
        @include('includes.error-field', ['fieldName' => 'last_name'])

        <label for='email'>E-Mail Address</label>
        <input id='email' type='email' name='email' value='{{ old('email') }}' required>
        @include('includes.error-field', ['fieldName' => 'email'])

        <label for='password'>Password (min: 8)</label>
        <input id='password' type='password' name='password' required>
        @include('includes.error-field', ['fieldName' => 'password'])

        <label for='password-confirm'>Confirm Password</label>
        <input id='password-confirm' type='password' name='password_confirmation' required>

        <button type='submit' class='btn btn-primary'>Register</button>
    </form>
@endsection