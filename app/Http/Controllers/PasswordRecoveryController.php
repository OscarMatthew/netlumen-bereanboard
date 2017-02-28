<?php

namespace App\Http\Controllers;

use App\PasswordReset;
use Illuminate\Support\Facades\Hash;
use App\User;
use Carbon\Carbon;
use App\Jobs\SendPasswordResetEmail;

class PasswordRecoveryController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function create()
    {
        return view('password-recovery.create');
    }

    public function check()
    {
        return view('password-recovery.check');
    }

    public function store()
    {
        $this->validate(request(), [
            'email' => 'exists:users'
        ]);
        $key = str_random(32);
        $email = request('email');

        $password_reset = PasswordReset::where('email', $email)->first();
        if ($password_reset) {
            $password_reset->token = bcrypt($key);
            $password_reset->created_at = new \DateTime();
            $password_reset->save();
        } else {
            PasswordReset::create([
                'email' => $email,
                'token' => bcrypt($key),
                'created_at' => new \DateTime()
            ]);
        }

        dispatch((new SendPasswordResetEmail($email, $key))->onQueue('email'));

        return redirect('/check-email');
    }

    public function resetForm($email, $key)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            request()->session()->flash('error', 'There was an error.');
            return redirect('/password-reset');
        }

        $password_reset = PasswordReset::where('email', $email)
            ->where('created_at', '>', Carbon::now()->subMinutes(10)->toDateTimeString())
            ->first();

        if (!$password_reset) {
            request()->session()->flash('error', 'Your token expired.');
            return redirect('/password-reset');
        }

        return view('password-recovery.reset', compact('email', 'key', 'user'));
    }

    public function reset(User $user)
    {
        $email = request('email');
        $key = request('key');
        $password_reset = PasswordReset::where('email', $email)->first();

        if (Hash::check($key, $password_reset->token)) {
            $this->validate(request(), [
                'password' => 'confirmed|min:6'
            ]);
            $user->password = bcrypt(request('password'));
            $user->save();
            $password_reset->delete();
            request()->session()->flash('success', 'Your password was successfully reset!');

            return redirect('/login');
        } else {
            return back()->withErrors(['message' => 'There was a problem.']);
        }
    }
}
