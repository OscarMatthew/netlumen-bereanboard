@extends('layout')

@section('content')
<hr style="margin: 0;">
    <table>
        <thead>
            <tr>
                <th><a href="/questions?s=votes">votes</a></th>
                <th><a href="/questions?s=answers">answers</a></th>
                <th><a href="/questions?s=views">views</a></th>
                <th style="text-align: right;">
                    <input type="text" name="book" style="margin: 0; width: 100px;" placeholder="John">
                    <input type="text" name="chapter" style="margin: 0; width: 50px;" placeholder="3">
                    <input type="text" name="verse" style="margin: 0; width: 50px;" placeholder="16">
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($questions as $question)
                <tr>
                    <td style="text-align: center; vertical-align: top;" class="{{ count($question->votes) > 0 ? 'color-success' : '' }} {{ count($question->votes) > 10 ? 'color-warning' : '' }} {{ count($question->votes) > 100 ? 'color-danger' : '' }}">
                        {{ count($question->votes) }}<br>
                        vote{{ count($question->votes) !== 1 ? 's' : '' }}
                    </td>
                    <td style="text-align: center; vertical-align: top;" class="{{ count($question->answers) > 0 ? 'color-success' : '' }} {{ count($question->answers) > 10 ? 'color-warning' : '' }} {{ count($question->answers) > 100 ? 'color-danger' : '' }}">
                        {{ count($question->answers) }}<br>
                        answer{{ count($question->answers) !== 1 ? 's' : '' }}
                    </td>
                    <td style="text-align: center; vertical-align: top;" class="{{ $question->views > 0 ? 'color-success' : '' }} {{ $question->views > 100 ? 'color-warning' : '' }} {{ $question->views > 1000 ? 'color-danger' : '' }}">
                        {{ $question->views }}<br>
                        view{{ $question->views !== 1 ? 's' : '' }}
                    </td>
                    <td>
                        <div>
                            <a href="/questions/{{ $question->id }}/{{ $question->slug() }}" style="font-size: 18px;">{{ $question->title }}</a>
                            <p style="margin-bottom: 10px;">{!! Markdown::lite(str_limit($question->body, 200)) !!}</p>
                            <a href="/users/{{ $question->author->id }}">{{ $question->author->username }}</a>
                            @if ($question->author->role !== 'user')
                                <span class="label label-{{ $question->author->role === 'moderator' ? 'gray' : 'primary' }}" style="margin: 0 5px;">
                                    {{ $question->author->role }}
                                </span>
                            @endif
                            {{ $question->created_at->diffForHumans() }}
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
