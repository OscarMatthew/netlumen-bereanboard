<?php

namespace App\Http\Controllers;

use App\Question;
use App\Services\MarkDown;

class QuestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    public function index()
    {
        $questions = Question::latest()->get();
        return view('questions.index', compact('questions'));
    }

    public function show(Question $question)
    {
        return view('questions.show', compact('question'));
    }

    public function create()
    {
        return view('questions.create');
    }

    public function store()
    {
        $this->validateQuestion();

        Question::create([
            'title' => request('title'),
            'body' => request('body'),
            'user_id' => auth()->user()->id
        ]);

        return redirect('/questions');
    }

    public function update(Question $question)
    {
        $this->authorize('edit-question', $question);
        $this->validateQuestion();
        $question->title = request('title');
        $question->body = request('body');
        $question->save();

        return MarkDown::parse($question->body);
    }

    public function destroy(Question $question)
    {
        $this->authorize('edit-question', $question);
        $question->delete();
        return redirect('/questions');
    }

    private function validateQuestion()
    {
        $this->validate(request(), [
            'title' => 'required'
        ]);
    }
}
