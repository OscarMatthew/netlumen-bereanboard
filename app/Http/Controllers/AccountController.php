<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = auth()->user();

        return view('account.show', compact('user'));
    }

    public function changeEmail()
    {
        $user = auth()->user();
        if (!$this->checkPassword($user, request('password'))) {
            return redirect('/account')->withErrors([
                'message' => 'You did not enter the correct password.'
            ]);
        }
        $this->validate(request(), [
            'email' => 'required|email|unique:users'
        ]);
        $user->email = request('email');
        $user->save();

        return redirect('/account');
    }

    public function changePassword()
    {
        $user = auth()->user();
        if (!$this->checkPassword($user, request('old_password'))) {
            return redirect('/account')->withErrors([
                'message' => 'You did not enter the correct password.'
            ]);
        }
        $this->validate(request(), [
            'new_password' => 'required|confirmed|min:6'
        ]);
        $user->password = bcrypt(request('new_password'));
        $user->save();

        return redirect('/account');
    }

    public function deactivateAccount()
    {
        $user = auth()->user();
        if (!$this->checkPassword($user, request('password'))) {
            return redirect('/account')->withErrors([
                'message' => 'You did not enter the correct password.'
            ]);
        }
        $user->active = false;
        $user->save();
        auth()->logout();

        return redirect('/');
    }

    private function checkPassword($user, $password)
    {
        return auth()->validate([
            'username' => $user->username,
            'password' => $password
        ]);
    }
}
