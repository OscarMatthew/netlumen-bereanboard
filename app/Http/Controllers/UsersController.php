<?php

namespace App\Http\Controllers;

use App\User;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sort = request('s');
        if (!$sort) $sort = 'id';
        $direction = request('d');
        if (!$direction) $direction = 'asc';
        $field = request('f');
        $value =request('v');

        if (request('f')) {
            $users = User::where($field, 'like', '%'.$value.'%')
                ->orderBy($sort, $direction)
                ->limit(100)
                ->get();
        } else {
            $users = User::orderBy($sort, $direction)
                ->limit(100)
                ->get();
        }

        return view('users.index', compact('users', 'sort', 'direction', 'field', 'value'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function update(User $user)
    {
        $this->authorize('edit-user', $user);

        if (request()->has('email')) {
            $this->validate(request(), [
                'email' => 'required|email|unique:users'
            ]);
            $user->email = request('email');
        }
        if (request()->has('role')) {
            $this->validate(request(), [
                'role' => 'required|string'
            ]);
            $user->role = request('role');
        }
        if (request()->has('active')) {
            $this->validate(request(), [
                'active' => 'required|boolean'
            ]);
            $user->active = request('active');
        }
        if (request()->has('password')) {
            $this->validate(request(), [
                'password' => 'required|min:6|confirmed'
            ]);
            $user->password = bcrypt(request('password'));
        }

        $user->save();

        return redirect('/users/'.$user->id);
    }
}
