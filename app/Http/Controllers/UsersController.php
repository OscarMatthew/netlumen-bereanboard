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

        if (null !== request('username')) $user->username = request('username');
        if (null !== request('email')) $user->email = request('email');
        if (null !== request('role')) $user->role = request('role');

        $user->save();

        return redirect('/users/'.$user->id);
    }
}
