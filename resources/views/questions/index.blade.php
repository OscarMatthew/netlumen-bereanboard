@extends('layout')

@section('content')
    @foreach ($questions as $question)
        <div style="margin-bottom: 40px;">
            <a href="/questions/{{ $question->id }}/{{ $question->slug() }}">{{ $question->title }}</a>
            <p style="margin: 0;">{!! Markdown::lite(str_limit($question->body, 200)) !!}</p>
            asked by {{ $question->author->username }} {{ $question->created_at->diffForHumans() }}
            <br>
            {{ count($question->answers) }} answer{{ count($question->answers) !== 1 ? 's' : '' }}
        </div>
    @endforeach
@endsection
