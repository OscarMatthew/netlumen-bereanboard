@extends('layout')

@section('content')
    <div id="question-div">
        <h3 id="question-title">{{ $question->title }}</h3>
        <div id="question-body">{!! Markdown::parse($question->body) !!}</div>
        <p>
            asked by
            {{ $question->author->username }}
            @if ($question->author->role !== 'user')
                <span class="label label-{{ $question->author->role === 'moderator' ? 'gray' : 'primary' }}">
                    {{ $question->author->role }}
                </span>
            @endif
            {{ $question->created_at->diffForHumans() }}

            @can('edit-question', $question)
                <a style="cursor: pointer; margin-left: 15px;" onclick="$('#question-div').hide();$('#edit-question').fadeIn()">edit</a>
            @endcan
        </p>
    </div>
    @can('edit-question', $question)
        <div id="edit-question" style="display: none;">
            <input type="text" id="question-title-input" value="{{ $question->title }}" style="width: 100%;">
            @include('questions.partials.format-buttons', ['textarea' => 'question-body-textarea'])
            <textarea id="question-body-textarea" style="height: 200px;" id="question-body">{{ $question->body }}</textarea>
            <button type="button" class="btn btn-primary" style="float: right;" onclick="saveQuestion()">Save Question</button>
            <button type="button" class="btn btn-danger" style="float: right; margin-right: 15px;" modal="delete-question-modal">Delete Question</button>
            <button id="cancel-edit-question" type="button" class="btn btn-gray" onclick="$('#edit-question').hide();$('#question-div').fadeIn()">Cancel</button>
            <div class="modal" id="delete-question-modal">
                <div class="modal-content small">
                    <div class="modal-header">
                        <h4>Delete Question</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to permanently delete this question?</p>
                        <form action="/questions/{{ $question->id }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <button type="submit" class="btn btn-danger" style="float: right;">Delete Question</button>
                            <button type="button" class="btn btn-gray close-modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="ten columns offset-by-two">
            <div id="answer-comments-div">
                @foreach ($question->comments as $comment)
                    @include('questions.partials.comment')
                @endforeach
            </div>
            @if (Auth::check())
                <a style="cursor: pointer;" onclick="$('#submit-question-comment').fadeIn()">add comment</a>
                <div id="submit-question-comment" style="display: none;">
                    <textarea id="submit-question-comment-body-textarea" name="body" placeholder="type your comment here" style="height: 100px;"></textarea>
                    <button class="btn btn-primary" onclick="submitQuestionComment({{ $question->id }})">Submit Comment</button>
                </div>
            @endif
        </div>
    </div>
    <hr>
    <h4>Answers</h4>
    <div id="answers-div">
        @forelse ($question->answers as $answer)
            @include('questions.partials.answer')
        @empty
            <p>There are no answers.</p>
        @endforelse
    </div>
    @if (Auth::check())
        <div id="submit-answer">
            @include('questions.partials.format-buttons', ['textarea' => 'submit-answer-body-textarea'])
            <textarea id="submit-answer-body-textarea" name="body" placeholder="type your answer here" style="height: 200px;"></textarea>
            <button class="btn btn-primary" onclick="submitAnswer()">Submit Answer</button>
        </div>
    @else
        <p>Login to answer this question.</p>
    @endif

@endsection

@section('javascript')
    <script>
    var dangerAlert = '<div class="alert alert-danger" style="display: none;"><a class="close-alert"><i class="fa fa-fw fa-times"></i></a>_message_</div>'

    function wrapText(e, openTag, closeTag, toHighlight) {
        var textArea = $('#' + e);
        var len = textArea.val().length;
        var start = textArea[0].selectionStart;
        var end = textArea[0].selectionEnd;
        var selectedText = textArea.val().substring(start, end);
        var y = textArea.scrollTop();
        if (start === end) var replacement = toHighlight;
        else var replacement = selectedText;
        textArea.val(textArea.val().substring(0, start) + openTag + replacement + closeTag + textArea.val().substring(end, len));
        textArea.focus();
        if (toHighlight) textArea[0].setSelectionRange(start + openTag.length, start + openTag.length + replacement.length);
        else textArea[0].setSelectionRange(start + openTag.length, start + openTag.length);
        textArea.scrollTop(y);
    }

    function saveQuestion() {
        $('#edit-question').fadeTo(0)
        $.post('/questions/{{ $question->id }}', { _token: '{{ csrf_token() }}', _method: 'put', title: $('#question-title-input').val(), body: $('#question-body-textarea').val() }, function (response) {
            $('#question-title').text($('#question-title-input').val())
            $('#question-body').html(response)
            $('#edit-question').hide()
            $('#question-div').fadeIn()
            $('#edit-question').find('.alert').fadeOut(function () { $(this).remove() })
        }).fail(function (data) {
            $('#edit-question').find('.alert').fadeOut(function () { $(this).remove() })
            $.each(JSON.parse(data.responseText), function (key, data) {
                $.each(data, function (index, data) {
                    $('#edit-question').prepend(dangerAlert.replace('_message_', data));
                    $('#edit-question').find('.alert').fadeIn()
                })
            })
        })
    }

    function submitAnswer() {
        $('#submit-answer').fadeTo(0)
        $.post('/answers', { _token: '{{ csrf_token() }}', question_id: {{ $question->id }},body: $('#submit-answer-body-textarea').val() }, function (response) {
            $('#answers-div').append('<div style="display: none;" class="new-answer">' + response + '</div>')
            $('.new-answer').fadeIn()
            $('#submit-answer').find('.alert').remove()
            $('#submit-answer-body-textarea').val('')
            $('body').animate({ scrollTop: $(document).height() })
        }).fail(function (data) {
            $('#submit-answer').find('.alert').fadeOut(function () { $(this).remove() })
            $.each(JSON.parse(data.responseText), function (key, data) {
                $.each(data, function (index, data) {
                    $('#submit-answer').prepend(dangerAlert.replace('_message_', data))
                    $('#submit-answer').find('.alert').fadeIn(function () {
                        $('body').animate({ scrollTop: $(document).height() })
                    })
                })
            })
        })
    }

    function saveAnswer(id) {
        $('#edit-answer-' + id).fadeTo(0)
        $.post('/answers/' + id, { _token: '{{ csrf_token() }}', _method: 'put', body: $('#save-answer-body-textarea-' + id).val() }, function (response) {
            $('#answer-body-' + id).html(response)
            $('#edit-answer-' + id).hide()
            $('#answer-div-' + id).fadeIn()
            $('#edit-answer-' + id).find('.alert').fadeOut(function () { $(this).remove() })
        }).fail(function (data) {
            $('#edit-answer-' + id).find('.alert').fadeOut(function () { $(this).remove() })
            $.each(JSON.parse(data.responseText), function (key, data) {
                $.each(data, function (index, data) {
                    $('#edit-answer-' + id).prepend(dangerAlert.replace('_message_', data));
                    $('#edit-answer-' + id).find('.alert').fadeIn()
                })
            })
        })
    }

    function deleteAnswer(id) {
        $('#edit-answer-' + id).fadeTo(0)
        $.post('/answers/' + id, { _token: '{{ csrf_token() }}', _method: 'delete' }, function () {
            $('#answer-comments-div-' + id).slideUp(function () {
                $('#edit-answer-' + id).slideUp()
            })
        })
    }

    function submitQuestionComment(question_id) {
        $('#submit-question-comment').fadeTo(0)
        $.post('/comments', { _token: '{{ csrf_token() }}', question_id: question_id, answer_id: null, body: $('#submit-question-comment-body-textarea').val() }, function (response) {
            $('#answer-comments-div').append('<div style="display: none;" class="new-comment">' + response + '</div>')
            $('#submit-question-comment').find('.alert').fadeOut(function () { $(this).remove() })
            $('#submit-question-comment-body-textarea').val('')
            $('#submit-question-comment').fadeOut(function() {
                $('.new-comment').fadeIn()
            })
        }).fail(function (data) {
            $('#submit-question-comment').find('.alert').fadeOut(function () { $(this).remove() })
            $.each(JSON.parse(data.responseText), function (key, data) {
                $.each(data, function (index, data) {
                    $('#submit-question-comment').prepend(dangerAlert.replace('_message_', data))
                    $('#submit-question-comment').find('.alert').fadeIn()
                })
            })
        })
    }

    function saveComment(id) {
        $('#edit-comment-' + id).fadeTo(0)
        $.post('/comments/' + id, { _token: '{{ csrf_token() }}', _method: 'put', body: $('#comment-body-textarea-' + id).val() }, function (response) {
            $('#comment-body-' + id).html(response)
            $('#edit-comment-' + id).hide()
            $('#comment-div-' + id).fadeIn()
            $('#edit-comment-' + id).find('.alert').fadeOut(function () { $(this).remove() })
        }).fail(function (data) {
            $('#edit-comment-' + id).find('.alert').fadeOut(function () { $(this).remove() })
            $.each(JSON.parse(data.responseText), function (key, data) {
                $.each(data, function (index, data) {
                    $('#edit-comment-' + id).prepend(dangerAlert.replace('_message_', data));
                    $('#edit-comment-' + id).find('.alert').fadeIn()
                })
            })
        })
    }

    function deleteComment(id) {
        $('#edit-comment-' + id).fadeTo(0)
        $.post('/comments/' + id, { _token: '{{ csrf_token() }}', _method: 'delete' }, function () {
            $('#edit-comment-' + id).slideUp()
        })
    }

    </script>
@endsection
