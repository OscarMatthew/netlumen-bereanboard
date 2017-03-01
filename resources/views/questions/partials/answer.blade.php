<div id="answer-div-{{ $answer->id }}">
    <div id="answer-body-{{ $answer->id }}">{!! Markdown::parse($answer->body) !!}</div>
    <p>
        answered by
        <a href="/users/{{ $answer->author->id }}">{{ $answer->author->username }}</a>
        @if ($answer->author->role !== 'user')
            <span class="label label-{{ $answer->author->role === 'moderator' ? 'gray' : 'primary' }}" style="margin: 0 5px;">
                {{ $answer->author->role }}
            </span>
        @endif
        {{ $answer->created_at->diffForHumans() }}
        @can('edit-answer', $answer)
            <a style="cursor: pointer; margin-left: 15px;" onclick="$('#answer-div-{{ $answer->id }}').hide();$('#edit-answer-{{ $answer->id }}').fadeIn()">edit</a>
        @endcan
    </p>
</div>
@can('edit-answer', $answer)
    <div id="edit-answer-{{ $answer->id }}" style="display: none;">
        @include('questions.partials.format-buttons', ['textarea' => 'save-answer-body-textarea-{{ $answer->id }}'])
        <textarea id="save-answer-body-textarea-{{ $answer->id }}" style="height: 200px;">{{ $answer->body }}</textarea>
        <button type="button" class="btn btn-primary" style="float: right;" onclick="saveAnswer({{ $answer->id }})">Save Answer</button>
        <button type="button" class="btn btn-danger" style="float: right; margin-right: 15px;" modal="delete-answer-modal-{{ $answer->id }}">Delete Answer</button>
        <button id="cancel-edit-answer-{{ $answer->id }}" type="button" class="btn btn-gray" onclick="$('#edit-answer-{{ $answer->id }}').hide();$('#answer-div-{{ $answer->id }}').fadeIn()">Cancel</button>
        <div class="modal" id="delete-answer-modal-{{ $answer->id }}">
            <div class="modal-content small">
                <div class="modal-header">
                    <h4>Delete Answer</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to permanently delete this answer?</p>
                    <button class="btn btn-danger close-modal" style="float: right;" onclick="deleteAnswer({{ $answer->id }})">Delete Answer</button>
                    <button class="btn btn-gray close-modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endcan
<div class="row" id="answer-comments-div-{{ $answer->id }}">
    <div class="ten columns offset-by-two">
        @foreach ($answer->comments as $comment)
            @include('questions.partials.comment')
        @endforeach
    </div>
</div>
