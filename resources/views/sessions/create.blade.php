@extends('layout')

@section('content')

    @include ('partials.errors')
    @include('partials.success')

    <div class="login-signup-wrapper">
        <div class="login-signup">
            <h3 style="margin-bottom: 20px;">Login</h3>
            <form action="/login" method="post" style="margin-bottom: 20px;">
                {{ csrf_field() }}
                <input type="text" name="username" placeholder="username or email" autofocus><br>
                <input type="password" name="password" placeholder="password"><br>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <a href="/password-reset">Forgot your password?</a>
        </div>
    </div>

@endsection
