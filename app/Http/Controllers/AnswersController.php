<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Services\MarkDown;

class AnswersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store()
    {
        $this->validateAnswer();

        $answer = Answer::create([
            'body' => request('body'),
            'question_id' => request('question_id'),
            'user_id' => auth()->user()->id
        ]);

        return view('questions.partials.answer', compact('answer'));
    }

    public function update(Answer $answer)
    {
        $this->authorize('edit-answer', $answer);
        $this->validateAnswer();

        $answer->body = request('body');
        $answer->save();

        return MarkDown::parse($answer->body);
    }

    public function destroy(Answer $answer)
    {
        $this->authorize('edit-answer', $answer);
        $answer->delete();
        return;
    }

    private function validateAnswer()
    {
        $messages = [
            'body.required' => 'The answer can not be blank.'
        ];

        $this->validate(request(), [
            'body' => 'required'
        ], $messages);
    }
}
