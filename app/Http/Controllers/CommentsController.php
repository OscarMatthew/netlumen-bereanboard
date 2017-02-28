<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Services\MarkDown;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store()
    {
        $this->validateComment();

        if (request('question_id') !== null) {
            $for = 'question_id';
            $id = request('question_id');
        } else {
            $for = 'answer_id';
            $id = request('answer_id');
        }

        $comment = Comment::create([
            'body' => request('body'),
            $for => $id,
            'user_id' => auth()->user()->id
        ]);

        return view('questions.partials.comment', compact('comment'));
    }

    public function update(Comment $comment)
    {
        $this->authorize('edit-comment', $comment);
        $this->validateComment();

        $comment->body = request('body');
        $comment->save();

        return MarkDown::lite($comment->body);
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('edit-comment', $comment);
        $comment->delete();
        return;
    }

    private function validateComment()
    {
        $messages = [
            'body.required' => 'The comment can not be blank.'
        ];

        $this->validate(request(), [
            'body' => 'required'
        ], $messages);
    }
}
