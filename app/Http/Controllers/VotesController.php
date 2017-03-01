<?php

namespace App\Http\Controllers;

use App\Vote;

class VotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store()
    {
        $vote = Vote::where('question_id', request('question_id'))
            ->where('user_id', auth()->user()->id)
            ->get()
            ;

        if (count($vote) > 0) {
            return 'error';
        }

        Vote::create([
            'user_id' => auth()->user()->id,
            'question_id' => request('question_id')
        ]);

        return Vote::where('question_id', request('question_id'))->count();
    }
}
