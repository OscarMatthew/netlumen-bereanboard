@extends('layout')

@section('content')
    <div class="nine columns">
        @include('partials.errors')
        <form action="/questions" method="post">
            {{ csrf_field() }}
            <input type="text" name="title" style="width: 100%;" placeholder="What is your question?">
            <textarea name="body" style="height: 400px;" placeholder="Explain your question here"></textarea>
            <button type="submit" class="btn btn-primary" style="float: right;">Ask Question</button>
            <button type="reset" class="btn btn-gray">Clear</button>
        </form>
    </div>
    <div class="three columns">
        <h4>Question Tips</h4>
        <p>Ask good questions.</p>
    </div>
@endsection
