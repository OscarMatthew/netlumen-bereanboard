@extends('layout')

@section('content')
    <table>
        <tbody>
            @foreach ($questions as $question)
                <tr>
                    <td style="text-align: center; vertical-align: top;">
                        {{ count($question->answers) }}<br>
                        vote{{ count($question->answers) !== 1 ? 's' : '' }}
                    </td>
                    <td style="text-align: center; vertical-align: top;">
                        {{ count($question->answers) }}<br>
                        answer{{ count($question->answers) !== 1 ? 's' : '' }}
                    </td>
                    <td style="text-align: center; vertical-align: top;">
                        {{ count($question->answers) }}<br>
                        view{{ count($question->answers) !== 1 ? 's' : '' }}
                    </td>
                    <td>
                        <div>
                            <a href="/questions/{{ $question->id }}/{{ $question->slug() }}">{{ $question->title }}</a>
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
