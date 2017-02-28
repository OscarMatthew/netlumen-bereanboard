<?php

namespace App\Http\Controllers;

use App\User;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('destroy');
        $this->middleware('throttle:10,1');
    }

    public function create()
    {
        return view('sessions.create');
    }

    public function store()
    {
        $field = filter_var(request('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $user = User::where($field, request('username'))->first();
        if (!$user ||
            !$user->active ||
            !auth()->attempt([
                $field => request('username'),
                'password' => request('password')
            ])
        ) {
            return back()->withErrors(['message' => 'Check your credentials.']);
        }

        return redirect()->intended('/');
    }

    public function destroy()
    {
        auth()->logout();

        return redirect('/');
    }
}
