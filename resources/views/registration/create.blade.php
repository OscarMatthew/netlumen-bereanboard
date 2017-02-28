@extends('layout')

@section('content')

    @include('partials.errors')

    <div class="login-signup-wrapper">
        <div class="login-signup">
            <h3 style="margin-bottom: 20px;">Sign Up</h3>
            <form action="/signup" method="post">
                {{ csrf_field() }}
                <input type="text" name="username" placeholder="username" autofocus minlength="3" maxlength="20" required><br>
                <input type="email" name="email" placeholder="email" required><br>
                <input type="password" name="password" placeholder="password" minlength="6" required><br>
                <input type="password" name="password_confirmation" placeholder="confirm password" minlength="6" required><br>
                <button type="submit" class="btn btn-primary">Sign Up</button>
            </form>
        </div>
    </div>

@endsection
