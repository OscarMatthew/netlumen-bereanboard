@extends('layout')

@section('content')

    @include('partials.errors')
    <div class="eight columns offset-by-two" style="text-align: center;">
        <h3 class="m-bottom">Send Email</h3>
        <form action="/email" method="post">
            {{ csrf_field() }}
            <input type="email" style="width: 100%; box-sizing: border-box;" name="to" placeholder="to" value="{{ Request::get('to') }}">
            <input type="text" style="width: 100%; box-sizing: border-box;" name="subject" placeholder="subject" autofocus>
            <textarea name="body" placeholder="type your message here"></textarea>
            <button type="button" class="btn btn-gray" id="btn-clear-body" style="margin-right: 15px;">Clear Body</button>
            <button type="submit" class="btn btn-primary">Send Email</button>
        </form>
    </div>

@endsection
