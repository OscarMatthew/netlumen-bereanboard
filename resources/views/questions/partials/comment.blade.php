<div id="comment-div-{{ $comment->id }}">
    <span id="comment-body-{{ $comment->id }}">{!! Markdown::lite($comment->body) !!}</span>
    <span style="color: #888;">
        {{ $comment->author->username }}
        {{ $comment->created_at->diffForHumans() }}
        @can('edit-comment', $comment)
            <a style="cursor: pointer; margin-left: 15px;" onclick="$('#comment-div-{{ $comment->id }}').hide();$('#edit-comment-{{ $comment->id }}').fadeIn()">edit</a>
        @endcan
    </span>
</div>
@can('edit-comment', $comment)
    <div id="edit-comment-{{ $comment->id }}" style="display: none;">
        <textarea id="comment-body-textarea-{{ $comment->id }}" style="height: 100px;">{{ $comment->body }}</textarea>
        <button type="button" class="btn btn-primary" style="float: right;" onclick="saveComment({{ $comment->id }})">Save Comment</button>
        <button type="button" class="btn btn-danger" style="float: right; margin-right: 15px;" modal="delete-comment-modal-{{ $comment->id }}">Delete Comment</button>
        <button id="cancel-edit-answer-{{ $comment->id }}" type="button" class="btn btn-gray" onclick="$('#edit-comment-{{ $comment->id }}').hide();$('#comment-div-{{ $comment->id }}').fadeIn()">Cancel</button>
        <div class="modal" id="delete-comment-modal-{{ $comment->id }}">
            <div class="modal-content small">
                <div class="modal-header">
                    <h4>Delete Comment</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to permanently delete this comment?</p>
                    <button class="btn btn-danger close-modal" style="float: right;" onclick="deleteComment({{ $comment->id }})">Delete Comment</button>
                    <button class="btn btn-gray close-modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endcan
